<?php

namespace App\Http\Resources\Api;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ClientResource extends JsonResource
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
            "uuid"=> $this->uuid,
            "client_number" => $this->client_number,
            "phones" => $this->occurrence_client_phones->pluck('phone')->implode(', '),
            "name" => $this->name,
            "cpf_cnpj" => $this->cpf_cnpj,
            'email' => $this->email,
        ];
    }
}
