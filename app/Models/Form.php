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
 * Class Form.
 *
 * @package namespace App\Models;
 */
class Form extends Model implements Transformable
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
        'name',
        'description',
        'foto',
        'type',
        'version',
        'status',
        'contractor_id',
        'version_date',
        'is_all',
    ];

    public function form_groups()
    {
        return $this->hasMany(FormGroup::class, 'form_id');
    }
    public function form_sections()
    {
        return $this->hasMany(FormSection::class, 'form_id')->orderBy("order", "asc");
    }

    public function occurrence_type_forms()
    {
        return $this->hasMany(OccurrenceTypeForm::class,'form_id');
    }

    public function occurrence_types()
    {
        return $this->belongsToMany(OccurrenceType::class,'occurrence_type_forms','form_id','occurrence_type_id');
    }

    public function occurrence_images()
    {
        return $this->hasMany(OccurrenceImage::class, 'form_id');
    }

    public function contractor()
    {
        return $this->belongsTo(Contractor::class, 'contractor_id');
    }

    public function form_versions()
    {
        return $this->hasMany(FormVersion::class, 'form_id')->orderby("id","asc");
    }

    public function pdfs()
    {
        return $this->hasMany(OccurrencePdf::class, 'form_id');
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
        'foto',
        'type',
        'version',
        'version_date',
        'is_all',
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
            return 'Inclusão de Formulário';
        }

        if ($eventName == 'updated') {
            return 'Alteração de Formulário';
        }

        if ($eventName == 'deleted') {
            return 'Exclusão de Formulário';
        }

        return $eventName;
    }
}
