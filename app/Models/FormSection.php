<?php

namespace App\Models;

use App\Traits\Multitenantable;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * Class FormSection.
 *
 * @package namespace App\Models;
 */
class FormSection extends Model implements Transformable
{
    use TransformableTrait;
    use Uuids;
    use SoftDeletes;
    use LogsActivity;
    use Multitenantable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'form_group_id',
        'form_id',
        'name',
        'description',
        'contractor_id',
        'required',
        'order',
    ];

    public function form()
    {
        return $this->belongsTo(Form::class,'form_id');
    }


    public function form_group()
    {
        return $this->belongsTo(FormGroup::class, 'form_group_id');
    }

    public function form_fields()
    {
        return $this->hasMany(FormField::class, 'form_section_id');
    }

    public function contractor()
    {
        return $this->belongsTo(Contractor::class, 'contractor_id');
    }

    protected static $logAttributes = [
        'name',
        'description',
    ];

    public function getDescriptionForEvent($eventName)
    {

        if ($eventName == 'created') {

            $returnUpdate['type'] = "Criação";
            $returnUpdate['de'] = $this->oldAttributes;
            $returnUpdate['para'] = $this->getAttributes();

            return json_encode($returnUpdate);
        }

        if ($eventName == 'updated') {

            $returnUpdate['type'] = "Alteração";
            $returnUpdate['de'] = $this->oldAttributes;
            $returnUpdate['para'] = $this->getAttributes();

            return json_encode($returnUpdate);
        }

        if ($eventName == 'deleted') {

            $returnUpdate['type'] = "Exclusão";
            $returnUpdate['de'] = $this->oldAttributes;
            $returnUpdate['para'] = $this->getAttributes();

            return json_encode($returnUpdate);
        }

        return $eventName;
    }


    public function getLogNameToUse($eventName)
    {
        if ($eventName == 'created') {
            return 'Inclusão de Seção';
        }

        if ($eventName == 'updated') {
            return 'Alteração de Seção';
        }

        if ($eventName == 'deleted') {
            return 'Exclusão de Seção';
        }

        return $eventName;
    }

}
