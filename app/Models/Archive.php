<?php

namespace App\Models;

use App\Traits\Multitenantable;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use App\Traits\Uuids;

/**
 * Class Archive.
 *
 * @package namespace App\Models;
 */
class Archive extends Model implements Transformable
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
        'type',
        'user_id',
        'url',
        'name',
        'original_name',
        'reference_id',
        'contractor_id'
    ];

    public function types()
    {

        switch ($this->type) {
            case "1": $tipo = "Veículos"; break;
        }
        return $tipo;
    }

    public function contractor()
    {
        return $this->belongsTo(Contractor::class);
    }

}
