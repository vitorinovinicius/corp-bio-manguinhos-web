<?php

    namespace App\Services\Api;


    use App\Criteria\Api\ExpenseCriteria;
    use App\Http\Resources\Api\ExpenseResource;
    use App\Repositories\ExpenseRepository;
    use App\Services\ArchiveService;
    use Auth;
    use Carbon\Carbon;
    use Illuminate\Support\Facades\Storage;

    class ExpenseService
    {
        /**
         * @var ArchiveService
         */
        private $archiveService;
        /**
         * @var ExpenseRepository
         */
        private $expenseRepository;


        /**
         * ExpenseService constructor.
         * @param ArchiveService $archiveService
         * @param ExpenseRepository $expenseRepository
         */
        public function __construct(ArchiveService $archiveService, ExpenseRepository $expenseRepository)
        {
            $this->archiveService = $archiveService;
            $this->expenseRepository = $expenseRepository;
        }

        public function list()
        {
            if (!Auth::guard('api')->check()) {
                return response()->json(["error" => "Erro na autenticacao"], 500);
            }

            $expenses = $this->expenseRepository->pushCriteria(new ExpenseCriteria())->all();

            return ExpenseResource::collection($expenses);
        }

        public function store($request)
        {
            if (!Auth::guard('api')->check()) {
                return response()->json(["error" => "Erro na autenticacao"], 500);
            }

            $data = $request->all();

            try {
                $photo = $request->file("photo_voucher");

                $data['user_id'] = Auth::guard('api')->user()->id;
                $data['contractor_id'] = Auth::guard('api')->user()->contractor_id;
                $data['category'] = 1;
                $data['date'] = Carbon::createFromFormat('d/m/Y', $request->input("date"))->format("Y-m-d");
                $data['photo_voucher'] = (isset($photo) && $photo) ? $photo->getClientOriginalName() : '';
                if(isset($data["value"]) && !empty($data["value"])){
                    $data['value'] = str_replace(",", ".", $data["value"]);
                }

                //Verifica se já existe
                if (isset($data["app_uuid"]) && !empty($data["app_uuid"])) {
                    $expense_find = $this->expenseRepository->findWhere(["app_uuid" =>$data["app_uuid"]])->first();
                    if($expense_find){
                        $expense = $this->expenseRepository->update($data, $expense_find->id);
                    }else{
                        $expense = $this->expenseRepository->create($data);
                    }
                } else {
                    $expense = $this->expenseRepository->create($data);
                }

                if (isset($photo) && $photo) {

                    if (!is_null($photo)) {
                        $path = \Auth::user()->contractor_id . "/reembolso/";
                        $this->archiveService->create(2, $photo, $path, $expense->id);
                    }
                }

                return new ExpenseResource($expense);
            } catch (\Exception $e) {
                geraActivityLog("API - Expense - Erro", "API - Erro ao salvar Expense", $e->getMessage());

                return response()->json([
                    'error' => 'Erro no sistema',
                    "exception" => $e->getMessage()
                ], 500);
            }

        }

        public function imageStore($request)
        {
            if (!Auth::guard('api')->check()) {
                return response()->json(
                    [
                        "status" => 2,
                        "error" => "Erro na autenticacao",
                        "message" => "Erro na autenticacao",
                    ],
                    500
                );
            }

            if (empty($request->all())) {
                geraActivityLog("Imagem - Erro", "Erro: Requisição vazia", json_encode($request->all()));

                return response()->json(
                    [
                        "status" => 2,
                        'error' => "O arquivo não pode ser salvo ou não existe localmente",
                        'message' => "O arquivo não pode ser salvo ou não existe localmente"
                    ],
                    500
                );
            }

            $imagem        = $request->input("image");
            $expense_id    = $request->input("expense_id");

            $s3Client = Storage::disk('s3');

            $fileName = md5(date("Y_m_d_h_i_s")) . "_" . $expense_id . ".jpg";
            $output_file_tmp = storage_path() . "/app/" . $fileName;
            $path = Auth::guard('api')->user()->contractor_id . "/reembolso/";
            $image_name      = env("S3_PATH"). Auth::guard('api')->user()->contractor_id . "/" .$path . $fileName;

            $img_tmp = base64ToImage($imagem, $output_file_tmp);

            if (\File::exists($img_tmp)) {

                $contents = \File::get($img_tmp);
                $s3Client->put($image_name, $contents);
                \File::delete($img_tmp);
                $url = $s3Client->url($image_name);

                return $this->archiveService->saveArchiveApi(2, $url, $fileName, $fileName, $expense_id);

            } else {
                geraActivityLog("Imagem - Erro", "O arquivo não pode ser salvo ou não existe localmente");

                return response()->json(['message' => "O arquivo não pode ser salvo ou não existe localmente"], 500);
            }

        }

    }
