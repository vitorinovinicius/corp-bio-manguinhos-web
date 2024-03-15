<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Traking.
 *
 * @package namespace App\Models;
 */
class Traking extends Model implements Transformable
{
    use TransformableTrait;
    use Uuids;
    use SoftDeletes;

    protected $fillable = [
        "user_id",
        "latitude",
        "longitude",
        "isConnect",
        "tipo_conexao",
        "device_version_number",
        "base_os",
        "codename",
        "version_sdk_int",
        "version_release",
        "product",
        "last_size",
        "observacao",

        'checkin_date',
        'device',
        'device_version',
        'mobile_number',
        'platform_mobile',
        'model',
        'battery',
        'ip',
    ];

    public function users(){
        return $this->belongsTo(User::class,'user_id');
    }

}
