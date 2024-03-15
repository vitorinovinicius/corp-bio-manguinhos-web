<?php

namespace App\Models;

use App\Traits\Multitenantable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use App\Traits\Uuids;

/**
 * Class Category.
 *
 * @package namespace App\Models;
 */
class Category extends Model implements Transformable
{
    use TransformableTrait;
    use Uuids;
    use SoftDeletes;
    use Multitenantable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'contractor_id',
        'name',
        'status',
    ];

    public function contractor()
    {
        return $this->belongsTo(Contractor::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_categories', 'product_id', 'category_id');
    }

    public function status()
    {
        switch($this->status){
            case 1:
                return "Ativa";
            break;
            case 2:
                return "Inativa";
            break;
        }
    }

}
