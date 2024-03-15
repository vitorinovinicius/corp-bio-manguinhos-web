<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class WorkdayPrograms.
 *
 * @package namespace App\Models;
 */
class WorkdayPrograms extends Model implements Transformable
{
    use TransformableTrait;
    use Uuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        "workday_id",
        "day",
        "hour",
        "working_day_start",
        "lunch_start",
        "lunch_end",
        "working_day_end",
    ];

    public function workday()
    {
        return $this->belongsTo(Workday::class,'workday_id');
    }

}
