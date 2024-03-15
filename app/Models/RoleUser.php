<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class RoleUser extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = "role_user";

    protected $fillable = [
        'user_id',
        'role_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, "user_id");
    }

    public function role()
    {
        return $this->belongsTo(Role::class, "role_id");
    }
}
