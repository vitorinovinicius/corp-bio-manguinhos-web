<?php

namespace App\Models;

use App\Traits\Multitenantable;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Workday.
 *
 * @package namespace App\Models;
 */
class Workday extends Model implements Transformable
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
        "name",
        "status",
        "contractor_id",
    ];

    public function contractor()
    {
        return $this->belongsTo(Contractor::class,'contractor_id');
    }

    public function workday_programs()
    {
        return $this->hasMany(WorkdayPrograms::class,'workday_id')->orderBy('day');
    }

    public function users()
    {
        return $this->hasMany(User::class,'workday_id');
    }

    public function getStatus()
    {
        if($this->status == 1){
            return "Ativo";
        }else{
            return "Inativo";
        }
    }

}
