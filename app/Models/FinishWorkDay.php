<?php

namespace App\Models;

use App\Traits\Multitenantable;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class FinishWorkDayController.
 *
 * @package namespace App\Models;
 */
class FinishWorkDay extends Model implements Transformable
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
        "operator_id",
        "status",
        "ocurrences_report",
        "date_record",
        "contractor_id"
    ];
    public function operator()
    {
        return $this->belongsTo(User::class,'operator_id');
    }
    public function contractor()
    {
        return $this->belongsTo(Contractor::class, 'contractor_id');
    }
}
