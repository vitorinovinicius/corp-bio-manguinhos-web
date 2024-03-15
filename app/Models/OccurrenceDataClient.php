<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class OccurrenceDataClient.
 *
 * @package namespace App\Models;
 */
class OccurrenceDataClient extends Model implements Transformable
{
    use TransformableTrait;
    use Uuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'occurrence_id',
        "cliente_tipo",
        "cliente_tipo_outros",
        "cliente_nome",
        "cliente_email",
        "cliente_cpf",
        "cliente_telefone",
        "cliente_recebe_email",
        "cliente_assinatura_tecnico",
    ];

    public function occurrence()
    {
        return $this->belongsTo(Occurrence::class, "occurrence_id");
    }



    public function cliente_tipo()
    {
        switch ($this->cliente_tipo) {
            case "99": $tipo = "Outros"; break;

            case "1": $tipo = "Próprio"; break;

            case "2": $tipo = "Parente"; break;

            default: $tipo = "-"; break;
        }
        return $tipo;
    }
}
