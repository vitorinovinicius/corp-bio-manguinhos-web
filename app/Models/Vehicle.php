<?php

namespace App\Models;

use App\Traits\Multitenantable;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use App\Traits\Uuids;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * Class Vehicle.
 *
 * @package namespace App\Models;
 */
class Vehicle extends Model implements Transformable
{
    use TransformableTrait;
    use Uuids;
    use LogsActivity;
    use Multitenantable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uuid',
        'contractor_id',
        'year',
        'document_date',
        'due_date',
        'placa',
        'chassi',
        'brand',
        'model',
        'type',
        'allocated'
    ];

    public function archives()
    {
        return $this->hasMany(Archive::class, 'reference_id');
    }

    public function checklist_vehicle_basics()
    {
        return $this->hasMany(ChecklistVehicleBasic::class, 'vehicle_id');
    }

    public function contractor()
    {
        return $this->belongsTo(Contractor::class, 'contractor_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id', 'vehicle_id');
    }

    public function types()
    {
        switch ($this->type){
            case 1: $tipo = 'Carro'; break;
            case 2: $tipo = 'Moto'; break;
        }

        return $tipo;
    }

    public function getDescriptionForEvent($eventName)
    {

        if ($eventName == 'created') {

            $returnUpdate['type'] = "Criação ";
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
            return 'Inclusão';
        }

        if ($eventName == 'updated') {
            return 'Alteração';
        }

        if ($eventName == 'deleted') {
            return 'Exclusão';
        }

        return $eventName;
    }
}

