<?php

namespace App\Models;

use App\Traits\Multitenantable;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class LogImportError.
 *
 * @package namespace App\Models;
 */
class LogImportError extends Model implements Transformable
{
    use TransformableTrait;
    use Uuids;
    use SoftDeletes;
    use Multitenantable;

    protected $fillable = [
        'uuid',
        'contractor_id',
        'log_import_id',
        'line_number',
        'line_detail',
        'error_message',
        'contractor_id'];

    public function logImport(){
        return $this->belongsTo(LogImport::class,'log_import_id');
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

}
