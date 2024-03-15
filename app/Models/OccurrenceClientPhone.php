<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class OccurrenceClientPhone.
 *
 * @package namespace App\Models;
 */
class OccurrenceClientPhone extends Model implements Transformable
{
    use TransformableTrait;
    use Uuids;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        "occurrence_client_id",
        'uuid',
        "phone",
        "obs"
    ];

    public function occurrence_client(){
        return $this->belongsTo(OccurrenceClient::class,'occurrence_client_id');
    }

}
