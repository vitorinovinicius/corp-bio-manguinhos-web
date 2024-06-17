<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;


/**
 * Class Imagen.
 *
 * @package namespace App\Models;
 */
class Imagem extends Model implements Transformable
{
    use TransformableTrait;
    use SoftDeletes;
    use Uuids;

    protected $table = 'Imagens';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'url_imagem',
        'tipo_imagem',
        'legenda'
    ];

    public function secoes()
    {
        return $this->belongsToMany(SecaoFormulario::class, "secao_imagens");
    }

    public function setores()
    {
        return $this->belongsToMany(Setor::class, "secao_imagens");
    }

    public function type()
    {
        if ($this->tipo_imagem == 1) {
            return "Figura";
        } else if ($this->tipo_imagem == 2) {
            return "Gráfico";
        }else if ($this->tipo_imagem == 3) {
            return "Tabela";
        }else {
            return "Não informado";
        }
    }

}
