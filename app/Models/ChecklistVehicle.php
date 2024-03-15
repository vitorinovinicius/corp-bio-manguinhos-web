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
class ChecklistVehicle extends Model implements Transformable
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
        "item_id",
        "option_id",
        "checklist_vehicle_basic_id",
        "acao_recomendada",
        "responsavel",
        "prazo",
        "contractor_id"
    ];

    public function item()
    {
        return $this->belongsTo(ChecklistVehicleIten::class, 'item_id');
    }

    public function contractor()
    {
        return $this->belongsTo(Contractor::class);
    }
}
