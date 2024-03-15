<?php

namespace App\Models;

use App\Traits\Multitenantable;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class FormGroup.
 *
 * @package namespace App\Models;
 */
class FormGroup extends Model implements Transformable
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
        'form_id',
        'name',
        'is_equipment',
        'contractor_id',
    ];

    public function form()
    {
        return $this->belongsTo(Form::class,'form_id');
    }

    public function form_sections()
    {
        return $this->hasMany(FormSection::class,'form_group_id');
    }
    public function contractor()
    {
        return $this->belongsTo(Contractor::class, 'contractor_id');
    }
}
