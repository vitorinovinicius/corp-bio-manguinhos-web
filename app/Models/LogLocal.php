<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Traking.
 *
 * @package namespace App\Models;
 */
class LogLocal extends Model implements Transformable
{
    use TransformableTrait;
    use Uuids;

    protected $fillable = [
        "error",
        "device_version_number",
        "base_os",
        "codename",
        "version_sdk_int",
        "version_release",
        "product",
        "last_size",
        "username",
    ];
}
