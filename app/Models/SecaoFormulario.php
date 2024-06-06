<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class SecaoFormulario.
 *
 * @package namespace App\Models;
 */
class SecaoFormulario extends Model implements Transformable
{
    use TransformableTrait;
    use Uuids;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'formulario_id',
        'setor_id',
        'secao_id',
        'user_id',
        'descricao',
        'texto',
        'limite_caracteres',
        'email_status',
        'status'
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function secoes()
    {
        return $this->belongsTo(Formulario::class);
    }

    public function setor()
    {
        return $this->belongsTo(Setor::class);
    }

    public function status()
    {
        if ($this->status == 0) {
            return "Pendente";
        } else if ($this->status == 1) {
            return "Em andamento";
        }else if ($this->status == 2) {
            return "Analisando";
        }else if ($this->status == 3) {
            return "Em correção";
        } else {
            return "Concluído";
        }
    }


}
