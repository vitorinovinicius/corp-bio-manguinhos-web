<?php

namespace App\Http\Resources\Api;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class FormsResource extends JsonResource
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
            "occurrence_type_id" => $this->occurrence_type_id,
            'form_id' => $this->form_id,
            'form_name' => $this->name,
            'is_required' => $this->is_required,
        ];
    }
}
