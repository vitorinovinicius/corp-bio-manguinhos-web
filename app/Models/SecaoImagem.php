<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class SecaoImagem.
 *
 * @package namespace App\Models;
 */
class SecaoImagem extends Model implements Transformable
{
    use TransformableTrait;
    use Uuids;
    use SoftDeletes;

    protected $table = 'secao_imagens';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'secao_formulario_id',
        'imagem_id',
    ];

    public function secao()
    {
        return $this->belongsTo(SecaoFormulario::class, "secao_formulario_id");
    }

    public function imagem()
    {
        return $this->belongsTo(Imagem::class, "imagem_id");
    }
}
