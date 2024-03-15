<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class ActivityLog extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = "activity_log";
    protected $fillable = [
        'log_name',
        'description',
        'subject_id',
        'subject_type',
        'causer_id',
        'causer_type',
        'properties'
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'causer_id');
    }
}
