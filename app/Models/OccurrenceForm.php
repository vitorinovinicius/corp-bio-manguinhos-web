<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 06/02/2019
 * Time: 12:30
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class OccurrenceForm extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = "occurrence_forms";

    protected $fillable = [
        "occurrence_id",
        "form_id",
    ];

    public function occurrence()
    {
        return $this->belongsTo(Occurrence::class, 'occurrence_id');
    }

    public function form()
    {
        return $this->belongsTo(Form::class, 'form_id');
    }

}
