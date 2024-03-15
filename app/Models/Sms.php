<?php

namespace App\Models;

use App\Traits\Multitenantable;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Sms.
 *
 * @package namespace App\Models;
 */
class Sms extends Model implements Transformable
{
    use TransformableTrait;
    use Uuids;
    use Multitenantable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'occurrence_client_id',
        'occurrence_id',
        'telefone',
        'conteudo',
        'agendamento',
        'data_envio',
        'status',
        'status_detalhe',
        'status_motivo',
        'contractor_id'
    ];

    public function occurrence()
    {
        return $this->belongsTo(Occurrence::class,'occurrence_id');
    }

    public function client()
    {
        return $this->belongsTo(OccurrenceClient::class,'occurrence_client_id');
    }

    public function contractor()
    {
        return $this->belongsTo(Contractor::class);
    }

    public function data_envio(){
        if($this->data_envio){
            return Carbon::parse($this->data_envio)->format("d/m/Y H:i:s");
        }else{
            return $this->data_envio;
        }
    }
    
    

}
