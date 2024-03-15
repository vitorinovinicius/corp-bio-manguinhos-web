<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class TicketImage.
 *
 * @package namespace App\Models;
 */
class TicketImage extends Model implements Transformable
{
    use TransformableTrait;
    use Uuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'url', 
        'reference', 
        'ticket_id', 
        'section_id', 
        'form_field_id', 
    ];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    public function section()
    {
        $this->belongsTo(TicketTypeSection::class);
    }

    public function field()
    {
        return $this->belongsTo(TicketTypeSectionField::class);
    }

}
