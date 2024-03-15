<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use App\Traits\Uuids;
use App\Traits\Multitenantable;

/**
 * Class OccurrencePdf.
 *
 * @package namespace App\Models;
 */
class OccurrencePdf extends Model implements Transformable
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
        'uuid',
        'type',
        'url',
        'occurrence_id',
        'form_id',
    ];

    public function occurrence()
    {
        return $this->belongsTo(Occurrence::class, 'occurrence_id');
    }

    public function form()
    {
        return $this->belongsTo(Form::class);
    }

}
