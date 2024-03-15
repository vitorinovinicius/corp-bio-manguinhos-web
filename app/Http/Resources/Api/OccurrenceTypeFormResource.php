<?php


namespace App\Http\Resources\Api;


use Illuminate\Http\Resources\Json\JsonResource;

class OccurrenceTypeFormResource extends JsonResource
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
            'form_id' => $this->id,
            'form_name' => $this->name,
            'is_required' => $this->is_required,
        ];
    }
}
