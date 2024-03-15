<?php
    /**
     * Created by PhpStorm.
     * User: user
     * Date: 16/11/2017
     * Time: 15:40
     */

    namespace App\Services;

    use App\Criteria\CancelamentoStatusSelectCriteria;
    use App\Http\Resources\Api\CancelamentoStatusResource;
    use App\Repositories\CancelamentoStatusRepository;
    use Exception;

    class CancelamentoStatusService
    {
        /**
         * @var CancelamentoStatusRepository
         */
        private $cancelamentoStatusRepository;

        /**
         * CancelamentoStatusService constructor.
         */
        public function __construct(CancelamentoStatusRepository $cancelamentoStatusRepository)
        {
            $this->cancelamentoStatusRepository = $cancelamentoStatusRepository;
        }

        public function download()
        {
            $this->cancelamentoStatusRepository->pushCriteria(new CancelamentoStatusSelectCriteria());
            $cancelamento_statuses = $this->cancelamentoStatusRepository->all();

            return response()->json(["data" => CancelamentoStatusResource::collection($cancelamento_statuses)], 200);
        }

        public function index()
        {
            $cancelamento_statuses = $this->cancelamentoStatusRepository->pushCriteria(new CancelamentoStatusSelectCriteria())->paginate(50);

            return view('cancelamento_statuses.index', compact('cancelamento_statuses'));
        }

        /**
         * Show the form for creating a new resource.
         *
         * @return Response
         */
        public function create()
        {
            if (!\Auth::user()->contractor_id) {
                return redirect()->route('cancelamento_statuses.index')->with('error', "Usuário sem empreiteira associada.");
            }
            
            return view('cancelamento_statuses.create');
        }

        /**
         * Store a newly created resource in storage.
         *
         * @param Request $request
         * @return Response
         */
        public function store($request)
        {
            if (!\Auth::user()->contractor_id) {
                return redirect()->route('cancelamento_statuses.index')->with('error', "Usuário sem empreiteira associada.");
            }

            $data = $request->all();

            try {
                $this->cancelamentoStatusRepository->create($data);
            } catch (Exception $e) {
                return redirect()->back()->withInput()->with('error', 'Erro ao tentar salvar o item. <br>Erro: ' . $e->getMessage());
            }

            return redirect()->route('cancelamento_statuses.index')->with('message', 'Item criado com sucesso.');
        }


        public function show($cancelamento_status)
        {
            return view('cancelamento_statuses.show', compact('cancelamento_status'));
        }

        /**
         * Show the form for editing the specified resource.
         *
         * @param int $id
         * @return Response
         */
        public function edit($cancelamento_status)
        {
            return view('cancelamento_statuses.edit', compact('cancelamento_status'));
        }

        /**
         * Update the specified resource in storage.
         *
         * @param int $id
         * @param Request $request
         * @return Response
         */
        public function update($cancelamento_status, $request)
        {
            $data = $request->all();

            try {
                $this->cancelamentoStatusRepository->update($data, $cancelamento_status->id);
            } catch (Exception $e) {
                return redirect()->back()->withInput()->with('error', 'Erro ao tentar editar o item. <br>Erro: ' . $e->getMessage());
            }

            return redirect()->route('cancelamento_statuses.index')->with('message', 'Item atualizado com sucesso.');
        }

        /**
         * Remove the specified resource from storage.
         *
         * @param int $id
         * @return Response
         */
        public function destroy($cancelamento_status)
        {
            try {
                $cancelamento_status->delete();
            } catch (Exception $e) {
                return redirect()->route('cancelamento_statuses.index')->with('error', 'Erro ao tentar excluir o item. <br>Erro: ' . $e->getMessage());
            }
            return redirect()->route('cancelamento_statuses.index')->with('message', 'Item deletado com sucesso.');
        }
    }
