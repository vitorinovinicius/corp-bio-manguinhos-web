<?php

namespace App\Models;

use App\Traits\Multitenantable;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class FormField.
 *
 * @package namespace App\Models;
 */
class FormField extends Model implements Transformable
{
    use TransformableTrait;
    use Uuids;
    use SoftDeletes;
    use Multitenantable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'form_section_id',
        'code',
        'acceptance_criteria',
        'item_inspection',
        'status',
        'contractor_id',
        'key',
        'type_field',
        'name',
        'description',
        'list',
        'value',
        'required',
        'is_photo',
        'min_photo',
        'required_photo',
    ];

    public function form_section()
    {
        return $this->belongsTo(FormSection::class, 'form_section_id');
    }

    public function occurrence_form_fields()
    {
        return $this->hasMany(OccurrenceFormField::class, 'form_field_id');
    }

    public function occurrence_images()
    {
        return $this->hasMany(OccurrenceImage::class, 'form_field_id');
    }

    public function occurrences()
    {
        return $this->belongsToMany(Occurrence::class, 'occurrence_form_fields', 'form_field_id', 'occurrence_id');
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
    public function contractor()
    {
        return $this->belongsTo(Contractor::class, 'contractor_id');
    }
}
