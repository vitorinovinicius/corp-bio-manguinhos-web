<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class GeneralSetting.
 *
 * @package namespace App\Models;
 */
class GeneralSetting extends Model implements Transformable
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
        's3_key',
        's3_secret',
        's3_region',
        's3_bucket',
        's3_path',
        'google_maps_key',
        'zenvia_account',
        'zenvia_password',
        'zenvia_from',
        'zenvia_status',
        'bitly_access_token',
        'redirect',
        'dynamodb_key',
        'dynamodb_secret',
        'dynamodb_region',
        'dynamodb_local_endpoint',
    ];

}
