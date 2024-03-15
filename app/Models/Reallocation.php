<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Reallocation.
 *
 * @package namespace App\Models;
 */
class Reallocation extends Model implements Transformable
{
    use TransformableTrait;
    use Uuids;

    protected $fillable = [
        'uuid',
        "occurrence_id",
        "operator_id",
        "status",
    ];

    public function occurrence(){
        return $this->belongsTo(Occurrence::class,'occurrence_id');
    }

    public function operator(){
        return $this->belongsTo(User::class,'operator_id');
    }

}
