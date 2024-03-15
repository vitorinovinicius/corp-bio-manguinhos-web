<?php

namespace App\Models;

use App\Traits\Uuids;
use App\Traits\Multitenantable;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Group.
 *
 * @package namespace App\Models;
 */
class Group extends Model implements Transformable
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
        'name',
        'description',
        'contractor_id', 
        'user_id',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function contractor()
    {
        return $this->belongsTo(Contractor::class);
    }

    public function occurrence_clients()
    {
        return $this->hasMany(OccurrenceClient::class);
    }

    public function ticketTypes()
    {
        return $this->hasMany(TicketType::class);
    }

}
