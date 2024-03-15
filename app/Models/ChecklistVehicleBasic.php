<?php

namespace App\Models;

use App\Traits\Multitenantable;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Adjustment.
 *
 * @package namespace App\Models;
 */
class ChecklistVehicleBasic extends Model implements Transformable
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
        "vehicle_id",
		"type_id",
        'condutor_id',
        'avaliador',
        'placa',
        'contractor_id',
        'data_checklist',
        "check_in_lat",
        "check_in_long",
        "check_in_date",
        "finish_date",
    ];
    public function condutor()
    {
        return $this->hasOne(User::class, 'id','condutor_id');
    }
    public function vehicle()
    {
        return $this->hasOne(Vehicle::class, 'id','vehicle_id');
    }
    public function itens()
    {
        return $this->hasMany(ChecklistVehicle::class, 'checklist_vehicle_id');
    }
    public function images()
    {
        return $this->hasMany(ChecklistVehicleImage::class, 'checklist_vehicle_id');
    }
    public function checklist_vehicles()
    {
        return $this->hasMany(ChecklistVehicle::class, 'checklist_vehicle_basic_id');
    }
    public function checklist_vehicle_images()
    {
        return $this->hasMany(ChecklistVehicleImage::class, 'checklist_vehicle_basic_id');
    }

    public function contractor()
    {
        return $this->belongsTo(Contractor::class, 'contractor_id');
    }

}
