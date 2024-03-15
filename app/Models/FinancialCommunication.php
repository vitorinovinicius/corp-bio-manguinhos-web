<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class FinancialCommunication.
 *
 * @package namespace App\Models;
 */
class FinancialCommunication extends Model implements Transformable
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
        'financial_id',
        'user_id',
        'message',
        'status',
        'anexo',
        'anexo_name'
    ];

    public function financial()
    {
        return $this->belongsTo(Financial::class,'financial_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function status()
    {
        /*
             "0" => "Pendente",
            "1" => "Resolvido",
            "2" => "Sendo avaliado",
         */

        switch ($this->status) {
            case 0 : $tipo = "Pendente"; break;
            case 1 : $tipo = "Resolvido"; break;
            case 2 : $tipo = "Sendo avaliado"; break;
            default : $tipo = "Pendente";
        }
        return $tipo;
    }

    public function created_at()
    {
        return Carbon::parse($this->created_at)->format("d/m/Y H:i:s");
    }

    public function updated_at()
    {
        return Carbon::parse($this->updated_at)->format("d/m/Y H:i:s");
    }
}
