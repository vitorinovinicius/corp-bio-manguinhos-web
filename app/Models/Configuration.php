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
 * Class systemConfiguration.
 *
 * @package namespace App\Models;
 */
class Configuration extends Model implements Transformable
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
        'contractor_id',
        'config_value',
        'config_key',
        'description',
        'tipo',
        'tipo_user',
        'tipo_form',
    ];


    public function getSettings()
    {
        return Configuration::pluck('config_value', 'config_key')->toArray();
    }

    public function contractor()
    {
        return $this->belongsTo(Contractor::class, 'contractor_id');
    }

    public function tipo_user()
    {
        if($this->tipo_user == 1){
            return "Empreiteira";
        }else if($this->tipo_user == 2){
            return "Geral";
        }

        return "-";
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
