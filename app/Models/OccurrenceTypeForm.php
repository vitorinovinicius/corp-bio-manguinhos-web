<?php

namespace App\Models;

use App\Traits\Multitenantable;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class OccurrenceTypeForm.
 *
 * @package namespace App\Models;
 */
class OccurrenceTypeForm extends Model implements Transformable
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
        'occurrence_type_id',
        'form_id',
        'is_required',
    ];

    public function occurrence_type()
    {
        return $this->belongsTo(OccurrenceType::class,'occurrence_type_id');
    }

    public function form()
    {
        return $this->belongsTo(Form::class,'form_id');
    }

}
