<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use App\Traits\Multitenantable;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Traits\Uuids;

/**
 * Class Zone.
 *
 * @package namespace App\Models;
 */
class Zone extends Model implements Transformable
{
    use TransformableTrait;
    use Uuids;
    use LogsActivity;
    use Multitenantable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uuid',
        'zone',
        'contractor_id',
    ];

    public function contractor()
    {
        return $this->belongsTo(Contractor::class, 'contractor_id');
    }

    public function occurrenceClients()
    {
        return $this->hasMany(OccurrenceClient::class, 'zone_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

}
