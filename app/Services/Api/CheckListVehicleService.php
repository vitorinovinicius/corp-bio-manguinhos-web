<?php

namespace App\Services\Api;

use App\Criteria\Api\ChecklistVehicleBasicMonthCriteria;
use App\Criteria\Api\ChecklistVehicleItensCriteria;
use App\Http\Resources\Api\CheckBasicResource;
use App\Http\Resources\Api\ChecklistItenResource;
use App\Models\ChecklistVehicleBasic;
use App\Repositories\ChecklistVehicle\ChecklistVehicleBasicRepository;
use App\Repositories\ChecklistVehicle\ChecklistVehicleImageRepository;
use App\Repositories\ChecklistVehicle\ChecklistVehicleItemRepository;
use App\Repositories\ChecklistVehicle\ChecklistVehicleRepository;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CheckListVehicleService
{
    /**
     * @var ChecklistVehicleItemRepository
     */
    private $checklistVehicleItemRepository;
    /**
     * @var ChecklistVehicleBasicRepository
     */
    private $checklistVehicleBasicRepository;
    /**
     * @var ChecklistVehicleRepository
     */
    private $checklistVehicleRepository;
    /**
     * @var ChecklistVehicleImageRepository
     */
    private $checklistVehicleImageRepository;

    /**
     * CheckListVehicleService constructor.
     * @param ChecklistVehicleItemRepository $checklistVehicleItemRepository
     * @param ChecklistVehicleBasicRepository $checklistVehicleBasicRepository
     * @param ChecklistVehicleRepository $checklistVehicleRepository
     * @param ChecklistVehicleImageRepository $checklistVehicleImageRepository
     */
    public function __construct(
        ChecklistVehicleItemRepository $checklistVehicleItemRepository,
        ChecklistVehicleBasicRepository $checklistVehicleBasicRepository,
        ChecklistVehicleRepository $checklistVehicleRepository,
        ChecklistVehicleImageRepository $checklistVehicleImageRepository
    )
    {

        $this->checklistVehicleItemRepository = $checklistVehicleItemRepository;
        $this->checklistVehicleBasicRepository = $checklistVehicleBasicRepository;
        $this->checklistVehicleRepository = $checklistVehicleRepository;
        $this->checklistVehicleImageRepository = $checklistVehicleImageRepository;
    }

    public function check()
    {
        $operator = Auth::user();

        if (!$operator) {
            return response()->json(['message'=>'Usuário não authenticado'], 500);
        }
        if (!$operator->vehicle) {
            return response()->json(['message'=>'Nenhum veículo vinculado para este operador.'], 500);
        }

        $checkList = [
            "vehicle" => [],
            "checked_this_month" => false,
            "chh_valid" => false,
            "checkListForm" => [],
        ];

        $checkList["vehicle"] = ($operator->vehicle) ? $operator->vehicle : null;
        $checkList["checked_this_month"] = $this->checklistIsExecuted();
        $checkList["checkListLastMonth"] = $this->checklistLastExecuted();
        $checkList["chh_valid"] = $this->checkCnhValid();
        $checkList["checkListForm"] = $this->formCheckList();

        return $checkList;

    }

    public function checklistIsExecuted()
    {
        $operator = Auth::user();

        $this->checklistVehicleBasicRepository->pushCriteria(new ChecklistVehicleBasicMonthCriteria());
        return ($this->checklistVehicleBasicRepository
            ->findWhere(["condutor_id"=>$operator->id])->first()) ? true : false;
    }
    public function checklistLastExecuted()
    {
        $operator = Auth::user();
        $vehicle = $operator->vehicle;

        $lastMonth = Carbon::now()->subMonth(6)->format("Y-m");
        $today = Carbon::now()->format("Y-m");

        $model = ChecklistVehicleBasic::whereBetween('finish_date', [$lastMonth. "-01 00:00:00", $today . "-31 23:59:59"]);
        $model->where('type_id', '=', $vehicle->type);
        $model->where('condutor_id', '=', $operator->id);
        $model->where('vehicle_id', '=', $vehicle->id);
        $model->orderby('finish_date', 'DESC');

        $lastChecklist = $model->first();
        return ($lastChecklist) ? new CheckBasicResource($lastChecklist) : null;
    }
    public function checkCnhValid()
    {
        $operator = Auth::user();

        $date = \Carbon\Carbon::parse($operator->cnh_expires . " 23:59:59");

        return ($date->isFuture()) ? true : false;
    }

    public function formCheckList(){
        $this->checklistVehicleItemRepository->pushCriteria(new ChecklistVehicleItensCriteria());

        return ChecklistItenResource::collection($this->checklistVehicleItemRepository->all());
    }

    public function store(Request $request){

        try {
            $basic = $request->input("basic");
            $checklist = $request->input("checklist");

            $operator = Auth::user();

            $basic['condutor_id'] = $operator->id;
            $basic['contractor_id'] = $operator->contractor_id;

            $checklist_vehicle_basic = $this->checklistVehicleBasicRepository->create($basic);


            if ($checklist_vehicle_basic) {
                foreach($checklist as $item) {
                    $item["checklist_vehicle_basic_id"] = $checklist_vehicle_basic->id;
                    $this->checklistVehicleRepository->create($item);
                }
            }

            return response()->json(
                [
                    'message'=>'Checklist realizado com sucesso.',
                    'checklist_vehicle_id'=>$checklist_vehicle_basic->id
                ], 200);

        } catch (\Exception $exception) {
            return response()->json(['erro'=>"Infelizmente aconteceu um problema", $exception->getMessage()], 500);
        }
    }

    public function storeImage(Request $request){

        try {
            $pathLog = "logs/";
            $nameLogRequest = "image_vehicle_log_request_json_" . date("Ymd") . ".log";

            if(!$request->input("image")) {
                gera_log($pathLog, $nameLogRequest, "UPLOAD IMAGEM - Não existe imagem");

                return response()->json(['message'=>"Não existe imagem"], 500);
            }

            if(!$request->input("checklist_vehicle_basic_id")) {
                gera_log($pathLog, $nameLogRequest, "UPLOAD IMAGEM - Cheklist não enviada");
                return response()->json(['message'=>"Checklist não foi enviado"], 500);
            }


            $inputImageLog = $request->all();
            $inputImageLog['image'] = null;

            if (env('GERA_LOG_REQUEST') == 1) {
                gera_log($pathLog, $nameLogRequest, $inputImageLog);
            }

            $checklist_vehicle_basic_id   = $request->input("checklist_vehicle_basic_id");
            $reference              = $request->input("reference");
            $imagem                 = $request->input("image");
            $uuid                   = $request->input("uuid");
            $type_id                = $request->input('type_id');
            $checklist_vehicle_basic = $this->checklistVehicleBasicRepository
                ->findWhere(["id"=>$checklist_vehicle_basic_id])
                ->first();


            if(!$checklist_vehicle_basic) {
                gera_log($pathLog, $nameLogRequest, "UPLOAD IMAGEM - Cheklist não enviada");
                return response()->json(['message'=>"Checklist não foi enviado"], 500);
            }

            $vehicleImage = $this->checklistVehicleImageRepository->findWhere(['uuid_external' => $uuid])
                ->first();

            if($vehicleImage) {
                return response()->json(['message' => "Imagem já existe"]);
            }

            $s3Client = Storage::disk('s3');

            $datetime        = date("Ymd_His");
            $output_file_tmp = storage_path() . "/app/" . $datetime . "_" . str_replace(" ","",$reference) . ".jpg";
            $image_name      = env("S3_PATH"). get_contractor_to_s3() ."images/checklist_vehicle/" .
                $checklist_vehicle_basic_id . "/" . $datetime . "_" .
                $reference . ".jpg";

            $img_tmp = $this->base64ToImage($imagem, $output_file_tmp);

            if (\File::exists($img_tmp)) {

                $contents = \File::get($img_tmp);
                $s3Client->put($image_name, $contents);
                \File::delete($img_tmp);
                $url = $s3Client->url($image_name);

                $this->saveImage($url, $checklist_vehicle_basic_id, $reference, $uuid, $type_id);

            } else {
                gera_log($pathLog, $nameLogRequest, "UPLOAD IMAGEM - " . "O arquivo número " . $reference . " -> " . $img_tmp . " não pode ser salvo ou não existe localmente");
                return response()->json(['message' => "O arquivo número " . $reference .
                    " -> " . $img_tmp .
                    " não pode ser salvo ou não existe localmente"], 500);
            }

            return response()->json(['url' => $url], 200);
        } catch (\Exception $exception) {
            return response()->json(['erro'=>"Infelizmente aconteceu um problema", $exception->getMessage()], 500);
        }
    }

    private function saveImage($url, $checklist_vehicle_basic_id, $reference=null, $uuid=null, $type_id=null){

        $data["checklist_vehicle_basic_id"]     = $checklist_vehicle_basic_id;
        $data["uuid_external"]     = $uuid;
        $data["url"]               = $url;
        $data["reference"]         = $reference;
        $data["type_id"]           = $type_id;
        return $this->checklistVehicleImageRepository->create($data);
    }
    private function base64ToImage($base64_string, $output_file)
    {
        $file = fopen($output_file, "wb");

        fwrite($file, base64_decode($base64_string));

        fclose($file);

        return $output_file;
    }
}
