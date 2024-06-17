<?php

namespace App\Models;

use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

/**
 * Class UserSetores.
 *
 * @package namespace App\Models;
 */
class UserSetores extends Model implements Transformable
{
    use TransformableTrait;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'user_id',
        'setor_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, "user_id");
    }

    public function setor()
    {
        return $this->belongsTo(Setor::class, "setor_id");
    }

}
