<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Uuids;

/**
 * Class Relatorio.
 *
 * @package namespace App\Models;
 */
class Relatorio extends Model implements Transformable
{
    use TransformableTrait;
    use Notifiable;
    use Uuids;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'url_documento',
        'descricao',
        'status'
    ];

}
