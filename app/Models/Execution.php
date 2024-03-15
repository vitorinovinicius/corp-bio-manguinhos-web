<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Execution.
 *
 * @package namespace App\Models;
 */
class Execution extends Model implements Transformable
{
    use TransformableTrait;
    use Uuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'occurrence_id',
        'observacao'
    ];

    public function occurrence()
    {
        return $this->belongsTo(Occurrence::class,'occurrence_id');
    }

}
