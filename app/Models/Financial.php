<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Financial.
 *
 * @package namespace App\Models;
 */
class Financial extends Model implements Transformable
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
        'user_id',
        'uuid',
        'status',
        'message',
        'data_approved',
    ];

    /*
     0 - Pendente
     1 - Aprovado
     2 - Reprovado
     3 - Solicitado ajuste
     4 - Ajuste feito pela ECC
     */

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function occurrence()
    {
        return $this->belongsTo(Occurrence::class,'occurrence_id');
    }

    public function financial_communications()
    {
        return $this->hasMany(FinancialCommunication::class, 'financial_id');
    }

    public function data_approved()
    {
        return $this->data_approved ? Carbon::parse($this->data_approved)->format("d/m/Y H:i:s") : "-";
    }

    public function created_at()
    {
        return $this->created_at ? Carbon::parse($this->created_at)->format("d/m/Y H:i:s") : "-";
    }

    public function status()
    {
        /*
             0 - Pendente
             1 - Aprovado
             2 - Reprovado
             3 - Solicitado ajuste
             4 - Ajuste feito pela ECC
         */

        switch ($this->status) {
            case 0 : $tipo = "Pendente"; break;
            case 1 : $tipo = "Aprovado"; break;
            case 2 : $tipo = "Reprovado"; break;
            case 3 : $tipo = "Solicitado ajuste"; break;
            case 4 : $tipo = "Ajustado pela ECC"; break;
            default : $tipo = 0;
        }
        return $tipo;
    }

    public function statusLabel()
    {
        if ($this->status == 0) {
            return "badge-primary";
        } else if ($this->status == 1) {
            return "badge-success";
        } else if ($this->status == 2) {
            return "badge-danger";
        } else if ($this->status == 3) {
            return "badge-warning";
        } else if ($this->status == 4) {
            return "badge-primary";
        }

        //"label-warning" : "label-primary" --
    }


}
