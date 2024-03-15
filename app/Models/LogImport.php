<?php

namespace App\Models;

use App\Traits\Multitenantable;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class LogImport.
 *
 * @package namespace App\Models;
 */
class LogImport extends Model implements Transformable
{
    use TransformableTrait;
    use Uuids;
    use SoftDeletes;
    use Multitenantable;

    protected static $logAttributes = [
//        'uuid',
        'contractor_id',
        'user_id',
        'name_archive',
        'url',
        'original_name',
        'qtd_error',
        'qtd_success',
        'lines',
        'archive_path',
        'contractor_id',
        'type_import'
    ];

    protected $fillable = ['uuid',
        'contractor_id',
        'user_id',
        'name_archive',
        'url',
        'original_name',
        'qtd_error',
        'qtd_success',
        'lines',
        'archive_path',
        'contractor_id',
        'type_import',
    ];

    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }

    public function logImportErrors(){
        return $this->hasMany(LogImportError::class,'log_import_id');
    }

    public function occurrences()
    {
        return $this->hasMany(Occurrence::class, 'log_import_id');
    }
}
