<?php

namespace App\Models;

use App\Traits\Uuids;
use App\Traits\Multitenantable;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class TicketTypeSection.
 *
 * @package namespace App\Models;
 */
class TicketTypeSection extends Model implements Transformable
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
        'uuid',
        'name',
        'description',
        'contractor_id',
        'ticket_type_id',
    ];

    public function contractor()
    {
        return $this->belongsTo(Contractor::class,'contractor_id');
    }

    public function ticketType()
    {
        return $this->belongsTo(TicketType::class, 'ticket_type_id');
    }

    public function ticketTypeSectionFields()
    {
        return $this->hasMany(TicketTypeSectionField::class);
    }

}
