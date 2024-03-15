<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class OccurrenceArchiveController.
 *
 * @package namespace App\Models;
 */
class OccurrenceArchive extends Model implements Transformable
{
    use TransformableTrait;
    use Uuids;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uuid',
        'occurrence_id',
        'user_id',
        'url',
        'name_original',
        'name',
        'size',
        'type_file',
    ];

    public function occurrence()
    {
        return $this->belongsTo(Occurrence::class,'occurrence_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function getExtension()
    {
        $str = explode('.', $this->url);
        return end($str);
    }

}
