<?php

namespace App\Models;

use App\Traits\Multitenantable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use App\Traits\Uuids;

/**
 * Class Routing.
 *
 * @package namespace App\Models;
 */
class Routing extends Model implements Transformable
{
    use TransformableTrait;
    use Uuids;
    use SoftDeletes;
    use Multitenantable;

    /**
     * dates
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * table
     *
     * @var string
     */
    protected $table = 'routings';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'contractor_id',
        'operator_id',
        'routing_date',
        'addresses',
        'routed_addresses',
        'type'
    ];

    public function contractor()
    {
        return $this->belongsTo(Contractor::class);
    }

    public function operator()
    {
        return $this->belongsTo(User::class);
    }

    public function types(){
        switch ($this->type){
            case 1: 
                return "TOMTOM"; 
            break;
            case 2: 
                return "GOOGLE"; 
            break;
        }

        
    }
}
