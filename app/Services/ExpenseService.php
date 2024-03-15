<?php

    namespace App\Services;

    use App\Criteria\ExpenseCriteria;
    use App\Criteria\OccurrenceBetweenScheduleCriteria;
    use App\Criteria\OperatorSelectCriteria;
    use App\Repositories\ArchiveRepository;
    use App\Repositories\ContractorRepository;
    use App\Repositories\ExpenseRepository;
    use App\Repositories\OccurrenceRepository;
    use App\Repositories\UserRepository;
    use Exception;
    use Illuminate\Support\Facades\Input;

    class ExpenseService
    {
        private $expenseRepository;
        private $occurrenceRepository;
        private $userRepository;
        private $archiveService;
        private $archiveRepository;
        /**
         * @var ContractorRepository
         */
        private $contractorRepository;

        /**
         * ExpenseService constructor.
         * @param ExpenseRepository $expenseRepository
         * @param OccurrenceRepository $occurrenceRepository
         * @param UserRepository $userRepository
         * @param ArchiveService $archiveService
         * @param ArchiveRepository $archiveRepository
         * @param ContractorRepository $contractorRepository
         */
        public function __construct(ExpenseRepository $expenseRepository, OccurrenceRepository $occurrenceRepository, UserRepository $userRepository, ArchiveService $archiveService, ArchiveRepository $archiveRepository, ContractorRepository $contractorRepository)
        {
            $this->expenseRepository = $expenseRepository;
            $this->occurrenceRepository = $occurrenceRepository;
            $this->userRepository = $userRepository;
            $this->archiveService = $archiveService;
            $this->archiveRepository = $archiveRepository;
            $this->contractorRepository = $contractorRepository;
        }

        public function listExpenses()
        {
            $expense_counts = $this->expenseRepository->pushCriteria(new ExpenseCriteria())->all();
            $expenses = $this->expenseRepository->paginate();
            $operators = $this->userRepository->pushCriteria(new OperatorSelectCriteria())->all();

            $total = $expense_counts->count();
            $paidOut = $expense_counts->where('status', '=', 2)->count(); //pago
            $pending = $expense_counts->where('status', '=', 1)->count(); // pendente
            $refused = $expense_counts->where('status', '=', 3)->count(); // recusado
            $inactive = $expense_counts->where('status', '=', 4)->count(); // recusado

            return view('expenses.index', compact('operators','total', 'paidOut', 'pending', 'refused', 'expenses', 'inactive'));
        }


        public function create()
        {
            if (!\Auth::user()->contractor_id) {
                return redirect()->route('expense.index')->with('error', "Apenas empresas têm acesso a criar o item.");
            }

            $operators = $this->userRepository->pushCriteria(new OperatorSelectCriteria())->all();

            return view('expenses.create', compact('operators'));
        }

        public function createOperatorExpense($operator, $startDate, $endDate)
        {
            $occurrences = $this->occurrenceRepository->pushCriteria(new OccurrenceBetweenScheduleCriteria($operator->id, $startDate, $endDate))->all();

            return view('expenses.create_operator', compact('operator', 'occurrences', 'startDate', 'endDate'));

        }

        // public function createOperatorRepayment()
        // {
        //     return view('repayment.create_operator');
        // }

        public function storeExpense($request)
        {
            if (!\Auth::user()->contractor_id) {
                return redirect()->route('expense.index')->with('error', "Apenas empresas têm acesso a criar o item.");
            }

            $data = $request->all();

            try {

                $expenseTypesID = $request->input("expense_types_id");
                $occurrenceID = $request->input("occurrence_id");
                $values = $request->input("value");
                $comment = $request->input("comment");
                $date = $request->input("date");
                $photo = $request->file("photo_voucher");

                foreach ($expenseTypesID as $key => $value) {
                    $data['expense_types_id'] = $expenseTypesID[$key];
                    $data['occurrence_id'] = ($occurrenceID[$key]) ? ($occurrenceID[$key]) : null;
                    $data['value'] = $values[$key];
                    $data['comment'] = $comment[$key];
                    $data['category'] = 1;
                    $data['date'] = $date[$key];
                    $data['photo_voucher'] = (isset($photo[$key]) && $photo[$key]) ? $photo[$key]->getClientOriginalName() : '';

                    $reembolso = $this->expenseRepository->create($data);

                    if (isset($photo[$key]) && $photo[$key]) {
                        $img[] = $photo[$key];

                        if (!is_null($img[0])) {
                            $path = \Auth::user()->contractor_id . "/reembolso/";
                            $this->archiveService->create(2, $img, $path, $reembolso->id);
                        }

                        unset($img);
                    }

                }

            } catch (Exception $e) {
                return redirect()->back()->withInput()->with('error', 'Erro ao tentar salvar a despesa. Entre em contato com o suporte.');
            }

            return redirect()->route('expense.index')->with('message', 'Despesa(s) criada(s) com sucesso.');

        }

        public function showExpense($expense)
        {
            return view('expenses.show', compact('expense'));
        }

        public function editExpense($expense)
        {

            if (!\Auth::user()->contractor_id) {
                return redirect()->route('expense.index')->with('error', "Apenas empresas têm acesso a criar o item.");
            }

            $operators = $this->userRepository->pushCriteria(new OperatorSelectCriteria())->all();

            return view('expenses.edit', compact('expense','operators'));
        }

        public function updateExpense($request, $expense)
        {
            $data = $request->all();

            try {
                $this->expenseRepository->update($data, $expense->id);
                return redirect()->route('expense.index')->with('message', 'Item atualizado com sucesso.');
            } catch (\Exception $e) {
                return redirect()->route('expense.index')->with('error', 'Erro ao atualizar o item.');
            }
        }

        public function destroyExpense($expense)
        {
            try {
                $this->expenseRepository->delete($expense->id);
                return redirect()->route('expense.index')->with('message', 'Item excluido com sucesso.');
            } catch (\Exception $e) {
                return redirect()->route('expense.index')->with('error', 'Erro ao excluir o item.');
            }
        }

        public function removePhoto($request)
        {
            $data = $request->all();
            try {

                $this->archiveRepository->delete($data["id"]);
                return response()->json([
                    'retorno' => 1,
                    'mensagem' => 'Arquivo apagado com sucesso!'
                ]);

                /*
                //Deleta imagem do S3
                $s3Client = Storage::disk('s3');
                $url_provisoria = str_replace("https://" . $this->aws_bucket . ".s3." . $this->aws_default_region . ".amazonaws.com/", "", $data["url"]);

                if ($s3Client->delete($url_provisoria)) {
                    $this->occurrenceImageRepository->delete($data["id"]);
                    return response()->json([
                        'retorno' => 1,
                        'mensagem' => 'Arquivo apagado com sucesso!'
                    ]);
                } else {
                    return response()->json([
                        'retorno' => 2,
                        'mensagem' => 'O arquivo não pode ser apagado do servidor'
                    ]);
                }
                */
            } catch (Exception $e) {
                return response()->json([
                    'retorno' => 2,
                    'mensagem' => $e->getMessage()
                ]);
            }
        }

        public function status($request)
        {
            $data = $request->all();

            try {
                $this->expenseRepository->update($data, $data['id']);
                return response()->json([
                    'retorno' => 1,
                    'mensagem' => 'Despesa alterada com sucesso'
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'retorno' => 2,
                    'mensagem' => $e->getMessage()
                ]);
            }
        }

        public function bulkStatus($request)
        {
            $data = $request->all();

            try {
                $status = $data['status'];
                foreach ($data['expenses'] as $expense) {
                    $this->expenseRepository->update(['status' => $status], $expense);
                }

                return response()->json([
                    'retorno' => 1,
                    'mensagem' => 'Despesa alterada com sucesso'
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'retorno' => 2,
                    'mensagem' => $e->getMessage()
                ]);
            }
        }
    }
