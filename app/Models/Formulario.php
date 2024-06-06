<?php

namespace App\Models;

use App\Traits\Multitenantable;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Formulario.
 *
 * @package namespace App\Models;
 */
class Formulario extends Model implements Transformable
{
    use TransformableTrait;
    use Uuids;
    use SoftDeletes;
    use Multitenantable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'relatorio_id',
        'descricao',
        'status'
    ];

    public function titulo()
    {
        return $this->hasMany(Formulario::class, 'sub_titulo_id');
    }

    public function setor()
    {
        return $this->belongsTo(Setor::class);
    }

    public function secoes()
    {
        return $this->hasMany(SecaoFormulario::class);
    }

}
