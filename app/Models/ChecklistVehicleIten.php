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
class ChecklistVehicleIten extends Model implements Transformable
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
        'type_id',
        'descricao',
        'contractor_id'
    ];

    public function contractor()
    {
        return $this->belongsTo(Contractor::class);
    }


    public function typeName()
    {
        switch ($this->type_id) {
            case "1": return "Carro"; break;
            case "2": return "Moto"; break;
            case "3": return "Ambos"; break;
            default: return "-"; break;
        }
    }
}
