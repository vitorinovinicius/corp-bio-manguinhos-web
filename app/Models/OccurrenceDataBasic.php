<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class OccurrenceDataBasic.
 *
 * @package namespace App\Models;
 */
class OccurrenceDataBasic extends Model implements Transformable
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
        'occurrence_id',
        'data_agendamento',
        'em_branco',
        'organizacao',
        'numero_os',
        'vip',
        'nome_os',
        'numero_cliente',
        'nome_cliente',
        'situacao_os',
        'endereco',
        'bairro',
        'telefone1',
        'telefone2',
        'telefone3',
        'municipio',
        'mercado',
        'prioridade',
        'n_os_garantia',
        'obs_ceg',
        'empreiteira',
        'cups',
        'codigo_solicitacao_zeus',
        'solicitacao_zeus',
        'telefone_zeus',
        'os_alias_name',
        'ot_alias_name',
        'tipo_agendamento',
        'area_origem',
        'area_responsavel',
        'data_solicitacao',
        'zona',
        'subzona',
        'valor_a_cobrar',
        'obs_empreiteira',
    ];

    public function occurrence()
    {
        return $this->belongsTo(Occurrence::class,"occurrence_id");
    }
}
