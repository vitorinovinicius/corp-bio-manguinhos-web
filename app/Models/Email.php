<?php

namespace App\Models;

use Prettus\Repository\Traits\TransformableTrait;
use Prettus\Repository\Contracts\Transformable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuids;

/**
 * Class Email.
 *
 * @package namespace App\Models;
 */
class Email extends Model implements Transformable
{
    use TransformableTrait;
    use SoftDeletes;
    use Uuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'remetente_id',
        'destinatario_id',
        'secao_formulario_id',
        'corpo'
    ];

    public function secaoFormulario()
    {
        return $this->belongsTo(SecaoFormulario::class, 'secao_formulario_id');
    }

    public function remetente()
    {
        return $this->belongsTo(User::class, 'remetente_id');
    }

    public function destinatario()
    {
        return $this->belongsTo(User::class, 'destinatario_id');
    }
}
