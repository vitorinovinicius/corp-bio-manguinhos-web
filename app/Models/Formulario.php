<?php

namespace App\Models;

use App\Traits\Multitenantable;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * Class Formulario.
 *
 * @package namespace App\Models;
 */
class Formulario extends Model implements Transformable
{
    use TransformableTrait;
    use Uuids;
    use SoftDeletes;
    use LogsActivity;
    use Multitenantable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'setor_id',
        'titulo',
        'sub_titulo',
        'limite_caracteres',
        'ANO'
    ];

    public function team()
    {
        return $this->hasOne(Team::class, 'id');
    }

}
