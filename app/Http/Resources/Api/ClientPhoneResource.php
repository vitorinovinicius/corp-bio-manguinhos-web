<?php

namespace App\Http\Resources\Api;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ClientPhoneResource extends JsonResource
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
            "occurrence_client_id" => $this->occurrence_client_id,
            "phone" => $this->phone,
            "obs" => $this->obs ? $this->obs : "",
        ];
    }
}
