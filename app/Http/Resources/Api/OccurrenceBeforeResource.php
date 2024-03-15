<?php

namespace App\Http\Resources\Api;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Collection;
class OccurrenceBeforeResource extends JsonResource
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
            "occurrence_id" => $this->id,
            "occurrenceTypeName"=> optional($this->occurrence_type)->name,
            "schedule_date"=> $this->schedule_date,
            "schedule_date_format"=> Carbon::parse($this->schedule_date)->format("d/m/Y"),
            "status"=> $this->status,
        ];
    }
}
