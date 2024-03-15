<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Adjustment.
 *
 * @package namespace App\Models;
 */
class ChecklistVehicleImage extends Model implements Transformable
{
    use TransformableTrait;
    use Uuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        "checklist_vehicle_basic_id",
        "url",
        "reference",
        "type_id", //0 veículo, 1 supervisor, 2 assinaturac
        "uuid_external",
    ];

    public function checklist_basic()
    {
        return $this->belongsTo(ChecklistVehicleBasic::class, 'checklist_vehicle_id');
    }
}
