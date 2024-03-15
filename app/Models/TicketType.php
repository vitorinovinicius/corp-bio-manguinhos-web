<?php

namespace App\Models;

use App\Traits\Uuids;
use App\Traits\Multitenantable;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class TicketType.
 *
 * @package namespace App\Models;
 */
class TicketType extends Model implements Transformable
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
        'group_id',
        'contractor_id'
    ];

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function contractor()
    {
        return $this->belongsTo(Contractor::class,'contractor_id');
    }

    public function ticketTypeSections()
    {
        return $this->hasMany(TicketTypeSection::class);    
    }

}
