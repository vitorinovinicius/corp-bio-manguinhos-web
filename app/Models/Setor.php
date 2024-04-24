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
 * Class Team.
 *
 * @package namespace App\Models;
 */
class Setor extends Model implements Transformable
{
    use TransformableTrait;
    use Uuids;
    use SoftDeletes;
    use Multitenantable;

    protected $table = 'setores';

    protected $fillable = [
        'uuid',
        'contractor_id',
        'name',
        'district',
    ];

    public function users(){
        return $this->belongsToMany(User::class,'user_setor','setor_id','user_id');
    }

    public function formulario(){
        return $this->belongsTo(Formulario::class,'setor_id');
    }

    public function contractor()
    {
        return $this->belongsTo(Contractor::class,'contractor_id');
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

