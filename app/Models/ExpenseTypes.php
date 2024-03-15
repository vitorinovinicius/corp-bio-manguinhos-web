<?php

namespace App\Models;

use App\Traits\Multitenantable;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class ExpenseTypes.
 *
 * @package namespace App\Models;
 */
class ExpenseTypes extends Model implements Transformable
{
    use TransformableTrait;
    use Uuids;
    use SoftDeletes;
    use Multitenantable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'contractor_id',
    ];

    public function contractor()
    {
        return $this->belongsTo(Contractor::class,'contractor_id');
    }

    public function reallocation()
    {
        return $this->hasMany(Reallocation::class, 'expense_types_id');
    }
}
