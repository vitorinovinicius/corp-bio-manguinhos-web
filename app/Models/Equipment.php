<?php

namespace App\Models;

use App\Traits\Multitenantable;
use App\Traits\Uuids;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Illuminate\Database\Eloquent\Model;

class Equipment extends Model implements Transformable
{
    use TransformableTrait;
    use Uuids;
    use Multitenantable;

    protected $table = "equipments";

    protected $fillable = [
        "name",
        "type",
        "validade",
        "contractor_id",
        "user_id",
        "status"
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function contractor()
    {
        return $this->belongsTo(Contractor::class, 'contractor_id');
    }

    public function status()
    {
        switch($this->status){
            case 1:
                return "Ativo";
            break;
            case 2:
                return "Inativo";
            break;
            case 3: 
                return "Reparo";
            break;
        }
    }
}
