<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class OccurrenceFormField.
 *
 * @package namespace App\Models;
 */
class OccurrenceFormField extends Model implements Transformable
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
        'form_field_id',
        'situation',
        'observation',
    ];

    public function occurrence()
    {
        return $this->belongsTo(Occurrence::class, 'occurrence_id');
    }

    public function form_field()
    {
        return $this->belongsTo(FormField::class, 'form_field_id');
    }

}
