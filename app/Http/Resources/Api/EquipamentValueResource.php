<?php

namespace App\Http\Resources\Api;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class EquipamentValueResource extends JsonResource
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
            "marca" => $this->marca,
            "modelo" => $this->modelo,
            "description" => $this->description,
            "litragem" => $this->litragem,
            "chamine_mm" => $this->chamine_mm,
            "pontos_pia" => ($this->pontos_pia == "") ? 0 : $this->pontos_pia,
            "pontos_ducha" => ($this->pontos_ducha == "") ? 0 : $this->pontos_ducha,
            "garantia" => $this->garantia,
            "preco" => $this->preco,
            "precoFormatado" => "R$ " . $this->preco,
            "desconto" => $this->desconto,
            "max_parcelamento" => $this->max_parcelamento,
            "tipo" => $this->tipo,
            "item" => $this->item,
            "obs" => $this->obs,
            "desconto_credito" => $this->desconto_credito,
            "desconto_debito" => $this->desconto_debito,
        ];
    }
}
