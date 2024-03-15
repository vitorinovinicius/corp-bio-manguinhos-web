<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class ExpenseResource extends JsonResource
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
            "user_id" => $this->user_id,
            "app_uuid" => $this->app_uuid,
            "occurrence_id" => $this->occurrence_id,
            "category" => $this->category,
            "expense_types_id" => $this->expense_types_id,
            "contractor_id" => $this->contractor_id,
            "value" => $this->value,
            "date" => Carbon::parse($this->date)->format("d/m/Y"),
            "photo_voucher" => $this->photo_voucher,
            "comment" => $this->comment,
            "status" => $this->status,
            "statuses" => $this->statuses(),
            "cancellation_reason" => $this->cancellation_reason,
            "refundable" => $this->refundable,
            'expenseTypes' => $this->expenseTypes,
            'archives' => $this->archives,
        ];
    }
}
