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
 * Class OccurrenceType.
 *
 * @package namespace App\Models;
 */
class OccurrenceType extends Model implements Transformable
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
        "uuid",
        "name",
        "description",
        "status",
        "contractor_id",
        "average_time"
    ];

    public function occurrences(){
        return $this->hasMany(Occurrence::class,'occurrence_type_id');
    }

    public function occurrence_type_forms()
    {
        return $this->hasMany(OccurrenceTypeForm::class,'occurrence_type_id');
    }

    public function forms()
    {
        return $this->belongsToMany(Form::class,'occurrence_type_forms','occurrence_type_id','form_id');
    }

    public function contractor_occurrence_types()
    {
        return $this->hasMany(ContractorOccurrenceType::class,'occurrence_type_id');
    }

    public function contractor()
    {
        return $this->belongsTo(Contractor::class, 'contractor_id');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected static $logAttributes = [
        'name',
        'description',
        'status',
        'contractor_id',
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
            return 'Inclusão de Tipo de OS';
        }

        if ($eventName == 'updated') {
            return 'Alteração de Tipo de OS';
        }

        if ($eventName == 'deleted') {
            return 'Exclusão de Tipo de OS';
        }

        return $eventName;
    }

    public function skills()
    {
        return $this->belongsToMany(Skill::class,'occurrence_type_skills','occurrence_type_id','skill_id');
    }

    public function planOccurrences()
    {
        return $this->hasMany(PlanOccurrence::class,'occurrence_type_id');
    }
}
