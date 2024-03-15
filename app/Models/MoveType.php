<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class MoveType.
 *
 * @package namespace App\Models;
 */
class MoveType extends Model implements Transformable
{
    use TransformableTrait;
    use Uuids;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        "name"
    ];

    public function moves()
    {
        return $this->hasMany(Move::class,'move_type_id');
    }

}
