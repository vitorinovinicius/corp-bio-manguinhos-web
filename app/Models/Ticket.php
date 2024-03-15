<?php

namespace App\Models;

use App\Traits\Multitenantable;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Ticket.
 *
 * @package namespace App\Models;
 */
class Ticket extends Model implements Transformable
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
        'uuid',
        'user_id',
        'description',
        'status',
        'justification',
        'email_status',
        'occurrence_client_id',
        'contractor_id',
        'description_type_ticket'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function occurrence()
    {
        return $this->hasOne(Occurrence::class);
    }

    public function occurrence_client()
    {
        return $this->belongsTo(OccurrenceClient::class);
    }

    public function ticketData()
    {
        return $this->hasOne(TicketData::class);
    }

    public function contractor()
    {
        return $this->belongsTo(Contractor::class,'contractor_id');
    }

    public static function getStatus($status)
    {
        switch ($status){
            case 1:
                return "Em aberto";
            case 2:
                return "Cancelado";
            case 3:
                return "Gerou OS";
        }
    }

    public function getStatusEmail()
    {
        switch ($this->email_status){
            case 1:
                return "E-mail de criação do ticket enviado";
            case 2:
                return "E-mail retornado";
            default:
                return "---";
        }
    }

}
