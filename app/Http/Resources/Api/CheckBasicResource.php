<?php

namespace App\Http\Resources\Api;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class CheckBasicResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "type_id" => $this->type_id,
            "contractor_id" => $this->contractor_id,
            "condutor_id" => $this->condutor_id,
            "vehicle_id" => $this->vehicle_id,
            "avaliador" => $this->avaliador,
            "placa" => $this->placa,
            "finish_date" => $this->finish_date,
            "check_list_executed" => CheckItensExecutedResource::collection($this->checklist_vehicles)        ];
    }
}
