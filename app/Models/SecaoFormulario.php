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

    
    public function pai()
    {
        return $this->belongsTo(SecaoFormulario::class, 'secao_id');
    }

    public function filhos()
    {
        return $this->hasMany(SecaoFormulario::class, 'secao_id');
    }

    public function formulario()
    {
        return $this->belongsTo(Formulario::class);
    }

    public function setor()
    {
        return $this->belongsTo(Setor::class);
    }

    public function imagens()
    {
        return $this->belongsToMany(Imagem::class, "secao_imagens");
    }

    public function secao_imagem()
    {
        return $this->hasMany(SecaoImagem::class, "secao_formulario_id");
    }

    public function emails()
    {
        return $this->hasMany(Email::class, "id");
    }

    public function status()
    {
        if ($this->status == 0) {
            return "Pendente";
        } else if ($this->status == 1) {
            return "Em andamento";
        }else if ($this->status == 2) {
            return "Em análise";
        }else if ($this->status == 3) {
            return "Em correção";
        } else {
            return "Concluído";
        }
    }

    public function badge_status()
    {
        if ($this->status == 0) {
            return "btn-secondary";
        } else if ($this->status == 1) {
            return "btn-primary";
        }else if ($this->status == 2) {
            return "btn-warning";
        }else if ($this->status == 3) {
            return "btn-danger";
        } else {
            return "btn-success";
        }
    }

    public function email_status()
    {
        if ($this->email_status == 0) {
            return "Não enviado";
        } else if ($this->email_status == 1) {
            return "Enviado";
        }else if ($this->email_status == 2) {
            return "Confirmado";
        }else {
            return "Revisão";
        }
    }

    public function icon_email_status()
    {
        if ($this->email_status == 0) {
            return "bx bx-x";
        } else if ($this->email_status == 1) {
            return "bx bx-check";
        }else if ($this->email_status == 2) {
            return "bx bx-check-double";
        }else {
            return "bx bx-revision";
        }
    }

    public function btn_email_status()
    {
        if ($this->email_status == 0) {
            return "text-danger";
        } else if ($this->email_status == 1) {
            return "text-primary";
        }else if ($this->email_status == 2) {
            return "text-success";
        }else {
            return "text-warning";
        }
    }

    public function getHierarchicalLevel()
    {
        $level = 1;
        $parent = $this->pai;
        while ($parent) {
            $level++;
            $parent = $parent->pai;
        }
        return $level;
    }


}
