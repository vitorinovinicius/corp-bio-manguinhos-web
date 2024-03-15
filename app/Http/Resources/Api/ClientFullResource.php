<?php

namespace App\Http\Resources\Api;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ClientFullResource extends JsonResource
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
            "id"=> $this->id,
            "uuid"=> $this->uuid,
            "client_number" => $this->client_number,
            "phones" => $this->occurrence_client_phones->pluck('phone')->implode(', '),
            "client_phones" => ($this->occurrence_client_phones) ? ClientPhoneResource::collection($this->occurrence_client_phones) : [],
            "name" => $this->name,
            "cpf_cnpj" => $this->cpf_cnpj ? $this->cpf_cnpj : "",
            'email' => $this->email ? $this->email : "",
            'address' => $this->address,
            'number' => $this->number,
            'cep' => $this->cep,
            'district' => $this->district,
            'city' => $this->city,
            'uf' => $this->uf,
            'complement' => $this->complement,
            'reference' => $this->reference,
            'zone' => ($this->zone) ? $this->zone->zone : '',
        ];
    }
}
