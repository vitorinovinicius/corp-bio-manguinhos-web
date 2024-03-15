<?php

namespace App\Models;

use App\Traits\Uuids;
use App\Traits\Multitenantable;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class TicketTypeSectionField.
 *
 * @package namespace App\Models;
 */
class TicketTypeSectionField extends Model implements Transformable
{
    use TransformableTrait;
    use Uuids;
    use Multitenantable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uuid', 
        'code', 
        'acceptance_criteria', 
        'item_inspection', 
        'status', 
        'type_field', 
        'name', 
        'description', 
        'list', 
        'value', 
        'required', 
        'required_photo', 
        'is_photo', 
        'min_photo', 
        'contractor_id', 
        'ticket_type_section_id', 
    ];

    public function contractor()
    {
        return $this->belongsTo(Contractor::class,'contractor_id');
    }

    public function ticketTypeSection()
    {
        return $this->belongsTo(TicketTypeSection::class);
    }

    public function status()
    {
        if ($this->status == 1) {
            return "Ativo";
        } else {
            return "Inativo";
        }
    }
    public function required()
    {
        if ($this->required == 1) {
            return "Sim";
        } else {
            return "Não";
        }
    }
    public function typeField()
    {
        if ($this->type_field == 1) {
            return "Checkbox";
        } else if($this->type_field == 2){
            return "Texto";
        } else if($this->type_field == 3){
            return "Radio";
        } else if($this->type_field == 4){
            return "Numérico";
        }  else if($this->type_field == 5){
            return "Imagem";
        }  else if($this->type_field == 6){
            return "Seleção";
        }  else if($this->type_field == 7){
            return "Assinatura";
        } else {
            return "-";
        }

    }


}
