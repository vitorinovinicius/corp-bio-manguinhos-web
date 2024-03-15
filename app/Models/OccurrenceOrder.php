<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use App\Traits\Uuids;

/**
 * Class OccurrenceOrder.
 *
 * @package namespace App\Models;
 */
class OccurrenceOrder extends Model implements Transformable
{
    use TransformableTrait;
    use Uuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'uuid',
        'operator_id',
        'flag',
        'flag_date', 
        'order_app',
    ];

    public function user(){
        return $this->belongsTo(User::class,'operator_id');
    }

}
