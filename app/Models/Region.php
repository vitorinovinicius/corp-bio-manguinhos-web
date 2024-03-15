<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Region.
 *
 * @package namespace App\Models;
 */
class Region extends Model implements Transformable
{
    use TransformableTrait;
    use Uuids;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'decription',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'region_users','region_id','user_id');
    }

    public function contractors()
    {
        return $this->belongsToMany(Contractor::class, 'region_contractors','region_id','contractor_id');
    }

    public function occurrences()
    {
        return $this->belongsTo(Occurrence::class,"region_id");
    }

}
