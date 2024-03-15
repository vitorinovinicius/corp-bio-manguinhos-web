<?php

namespace App\Models;

use App\Traits\Uuids;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Moves.
 *
 * @package namespace App\Models;
 */
class Move extends Model implements Transformable
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
        "move_type_id",
        "operator_id",
        "occurrence_id",
        "check_in_lat",
        "check_in_long",
        "check_out_lat",
        "check_out_long",
        "check_in",
        "check_out",
    ];

    public function move_type(){
        return $this->belongsTo(MoveType::class,'move_type_id');
    }

    public function occurrence(){
        return $this->belongsTo(Occurrence::class,'occurrence_id');
    }

    public function operator(){
        return $this->belongsTo(User::class,'operator_id');
    }

    public function dateCheckin()
    {
        return Carbon::parse($this->check_in)->format('d/m/Y H:i');
    }

    public function dateCreated()
    {
        return Carbon::parse($this->created_at)->format('d/m/Y H:i');
    }

}
