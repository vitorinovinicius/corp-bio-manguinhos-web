<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuids;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;


class FormVersion extends Model implements Transformable
{
    use TransformableTrait;
    use Uuids;

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    protected $table = "form_versions";


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uuid',
        'form_id',
        'version',
        'json'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
//        'id'
    ];

    public function form()
    {
        return $this->belongsTo(Form::class, 'form_id');
    }
}
