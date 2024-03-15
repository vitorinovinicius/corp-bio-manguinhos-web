<?php

namespace App\Http\Resources\Api;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class CheckItensExecutedResource extends JsonResource
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
            "uuid" => $this->uuid,
            "checklist_vehicle_basic_id" => $this->checklist_vehicle_basic_id,
            "item_id" => $this->item_id,
            "option_id" => $this->option_id,
            "acao_recomendada" => $this->acao_recomendada,
            "responsavel" => $this->responsavel,
            "prazo" => $this->prazo,
        ];
    }
}
