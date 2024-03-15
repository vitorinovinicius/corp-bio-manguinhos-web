<?php

namespace App\Models;

use App\Traits\Multitenantable;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Alert extends Model implements Transformable
{
    use TransformableTrait;
    use Uuids;
    use Multitenantable;

    protected $fillable = [
        'occurrence_id',
        'detail',
        'treated_detail',
        'treated_date',
        'contractor_id',
        'type',
        'user_id',
        'treated_user_id',
    ];


    public function treated_user()
    {
        return $this->belongsTo('App\Models\User', 'treated_user_id');
    }
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function occurrence()
    {
        return $this->belongsTo(Occurrence::class, 'occurrence_id');
    }

    //Retorna a descrição do tipo de alerta
    public function types()
    {
        switch($this->type){
            case 1:
                return "OS em atraso";
                break;
            case 2:
                return "OS com interferência";
                break;
            case 3:
                return "Equipamento";
            case 4:
                return "Atendimento acima do tempo médio";
                break;
            case 5:
                return "Hora extra ";
                break;
        }
    }

    public function treated_date()
    {
        return $this->treated_date ? date('d/m/Y H:i', strtotime($this->treated_date)) : '';
    }

    public function created_at()
    {
        return $this->created_at ? date('d/m/Y H:i:s', strtotime($this->created_at)) : '';
    }

    public function contractor()
    {
        return $this->belongsTo(Contractor::class);
    }
}
