<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use App\Traits\Uuids;

/**
 * Class Evaluation.
 *
 * @package namespace App\Models;
 */
class Evaluation extends Model implements Transformable
{
    use TransformableTrait;
    use Uuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'evaluations';
    protected $fillable = [
        'occurrence_id',
        'rate',
        'comment',
    ];

    public function occurrence()
    {
        return $this->belongsTo(Occurrence::class, 'occurrence_id');
    }

}
