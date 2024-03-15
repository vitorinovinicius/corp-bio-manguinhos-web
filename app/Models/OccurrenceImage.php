<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class OccurrenceImage.
 *
 * @package namespace App\Models;
 */
class OccurrenceImage extends Model implements Transformable
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
        'uuid',
        'occurrence_id',
        'url',
        'reference',
        'uuid_external',
        'form_id',
        'form_field_id',
        'position',
    ];

    public function occurrence(){
        return $this->belongsTo(Occurrence::class,'occurrence_id');
    }

    public function form()
    {
        return $this->belongsTo(Form::class,'form_id');
    }

    public function form_field()
    {
        return $this->belongsTo(FormField::class,'form_field_id');
    }

}
