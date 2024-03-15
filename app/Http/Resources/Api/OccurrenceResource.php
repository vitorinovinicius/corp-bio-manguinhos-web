<?php

namespace App\Http\Resources\Api;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class OccurrenceResource extends JsonResource
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
            "uuid"=> $this->uuid,
            "number_extern"=> $this->numero_os,
            "operator_id"=> $this->operator_id,
            "priority"=> priority_name($this->priority),
            "occurrence_type_id"=> $this->occurrence_type_id,
            "occurrence_client_id"=> $this->occurrence_client_id,
            "schedule_date"=> $this->schedule_date,
            "schedule_date_format"=> Carbon::parse($this->schedule_date)->format("d/m/Y"),
            "status"=> $this->status,
            "endereco"=> optional($this->occurrence_client)->address,
            "city"=> optional($this->occurrence_client)->city,
            "number"=> optional($this->occurrence_client)->number,
            "bairro"=> optional($this->occurrence_client)->district,
            "complement"=> optional($this->occurrence_client)->complement,
            "endereco_google"=> optional($this->occurrence_client)->address .", ".optional($this->occurrence_client)->number." - ".optional($this->occurrence_client)->district . " - " . optional($this->occurrence_client)->city . " - " . " - " . optional($this->occurrence_client)->uf . " - " . optional($this->occurrence_client)->cep,
            "created_at"=> $this->created_at,
            "updated_at"=> $this->updated_at,
            "occurrenceTypeName"=> optional($this->occurrence_type)->name,
            "plan"=> 0,
            "shift"=> $this->shift(),
            /**
             * Data Basics
             */
            "obs_empresa"=> $this->obs_empreiteira,
            "obs_empreiteira"=> $this->obs_empreiteira,
            "numero_os"=> $this->numero_os,
            "client" => new ClientResource($this->occurrence_client),
            "occurrence_forms"      => $this->occurrence_forms,
            "occurrence_before" => new OccurrenceBeforeResource($this->occurrence_before),

        ];
    }
}
