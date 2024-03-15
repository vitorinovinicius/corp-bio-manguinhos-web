<?php

namespace App\Models;

use App\Traits\Multitenantable;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

/**
 * Class Expense.
 *
 * @package namespace App\Models;
 */
class Expense extends Model implements Transformable
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
        "user_id",
        "occurrence_id",
        "category",
        "expense_types_id",
        "contractor_id",
        "value",
        "date",
        "photo_voucher",
        "comment",
        "status",
        "cancellation_reason",
        "refundable",
        "app_uuid",
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function occurrence()
    {
        return $this->belongsTo(Occurrence::class);
    }

    public function expenseTypes()
    {
        return $this->belongsTo(ExpenseTypes::class);
    }

    public function contractor()
    {
        return $this->belongsTo(Contractor::class);
    }

    public function archives()
    {
        return $this->hasMany(Archive::class, 'reference_id')->where([
            // 'contractor_id' => Auth::user()->contractor_id,
            'type'=> 2
        ]);
    }

    public function category()
    {
        switch($this->category){
            case 1 :
                return "Avulso";
                break;
            case 2:
                return "KM";
                break;
        }
    }

    public function statuses()
    {
        switch($this->status){
            case 1:
                return "Pendente";
                break;
            case 2:
                return "Pago";
                break;
            case 3:
                return "Recusado";
                break;
            case 4:
                return "Inválido";
                break;
        }
    }

    public function status_label()
    {
        switch($this->status){
            case 1:
                return "badge-warning";
                break;
            case 2:
                return "badge-success";
                break;
            case 3:
                return "badge-danger";
                break;
            case 4:
                return "badge-secondary";
                break;
        }
    }

    public function dateFormat()
    {
        return Carbon::parse($this->date)->format("d/m/Y");
    }

}
