<?php


namespace App\Http\Resources\Api;


use Illuminate\Http\Resources\Json\JsonResource;

class OccurrenceFormResource extends JsonResource
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
            'form_id' => $this->form_id,
            'form_name' => $this->form->name,
            'is_required' => $this->form->is_required,
        ];
    }
}
