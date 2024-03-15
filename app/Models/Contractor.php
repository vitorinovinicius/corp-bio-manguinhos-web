<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * Class Contractor.
 *
 * @package namespace App\Models;
 */
class Contractor extends Model implements Transformable
{
    use TransformableTrait;
    use Uuids;
    use softDeletes;
    use LogsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'name',
        'decription',
        'icon',
        'logo_cabecalho',
        'address',
        'cnpj',
        'phone1',
        'phone2',
        'email',
        'site',
        'mail_driver',
        'mail_host',
        'mail_port',
        'mail_from_address',
        'mail_from_name',
        'mail_encryption',
        'mail_username',
        'mail_password',
        'status',
        'visibility',
        'financial_pendency',
        'send_sms',
        'send_mail',
        'lat',
        'lng',
        'send_email_bbc',
        'client_limit'
    ];

    public function regions()
    {
        return $this->belongsToMany(Region::class, 'region_contractors', 'contractor_id', 'region_id');
    }

    public function users()
    {
        return $this->hasMany(User::class, 'contractor_id');
    }

    public function configurations()
    {
        return $this->hasMany(Configuration::class, 'contractor_id');
    }

    public function teams()
    {
        return $this->hasMany(Team::class, 'contractor_id');
    }

    public function occurrences()
    {
        return $this->hasMany(Occurrence::class, 'contractor_id');
    }

    public function finish_work_day()
    {
        return $this->hasMany(FinishWorkDay::class, 'contractor_id');
    }

    public function documents()
    {
        return $this->hasMany(Document::class, "contractor_id");
    }

    public function skills()
    {
        return $this->hasMany(Skill::class, "contractor_id");
    }

    public function clients()
    {
        return $this->hasMany(OccurrenceClient::class);
    }

    public function interferences()
    {
        return $this->hasMany(Interference::class, "contractor_id");
    }

    public function cancelamentoStatus()
    {
        return $this->hasMany(CancelamentoStatus::class, "contractor_id");
    }

    public function alerts()
    {
        return $this->hasMany(Alerts::class, "contractor_id");
    }

    public function archives()    {

        return $this->hasMany(Archive::class, "contractor_id");
    }

    public function sms()    {

        return $this->hasMany(Sms::class, "contractor_id");
    }

    public function categories()
    {
        return $this->hasMany(Category::class, "contractor_id");
    }

    public function products()
    {
        return $this->hasMany(Product::class, "contractor_id");
    }

    public function routings()
    {
        return $this->hasMany(Routing::class, 'contractor_id');
    }

    public function checklitVehicleItens()
    {
        return $this->hasMay(ChecklistVehicleIten::class);
    }

    public function checkListVehicle()
    {
        return $this->hasMany(ChecklistVehicle::class);
    }

    public function planOccurrences()
    {
        return $this->hasMany(PlanOccurrence::class,'contractor_id');
    }

    public function workdays()
    {
        return $this->hasMany(Workday::class, 'contractor_id');
    }

    public function zones()
    {
        return $this->hasMany(Zone::class, 'contractor_id');
    }



    //CAMPOS INTERNOS
    public function visibility()
    {
        return $this->visibility ? "Visível" : "Não visível";
    }

    public function status()
    {
        return $this->status ? "Habilitada" : "Desabilitada";
    }

    public function financialPendency()
    {
        return $this->financial_pendency ? "Sim" : "Não";
    }


    public function getDescriptionForEvent($eventName)
    {

        if ($eventName == 'created') {

            $returnUpdate['type'] = "Criação ";
            $returnUpdate['de'] = $this->oldAttributes;
            $returnUpdate['para'] = $this->getAttributes();

            return json_encode($returnUpdate);
        }

        if ($eventName == 'updated') {

            $returnUpdate['type'] = "Alteração";
            $returnUpdate['de'] = $this->oldAttributes;
            $returnUpdate['para'] = $this->getAttributes();

            return json_encode($returnUpdate);
        }

        if ($eventName == 'deleted') {

            $returnUpdate['type'] = "Exclusão";
            $returnUpdate['de'] = $this->oldAttributes;
            $returnUpdate['para'] = $this->getAttributes();

            return json_encode($returnUpdate);
        }

        return $eventName;
    }


    public function getLogNameToUse($eventName)
    {
        if ($eventName == 'created') {
            return 'Inclusão';
        }

        if ($eventName == 'updated') {
            return 'Alteração';
        }

        if ($eventName == 'deleted') {
            return 'Exclusão';
        }

        return $eventName;
    }

    public function getBbc()
    {
        switch($this->send_email_bbc){
            case 1:
                return "Enviar somente para cliente";
                break;
            case 2:
                return "Enviar somente para operador";
                break;
            case 3:
                return "Enviar para ambos (cliente e operador)";
                break;
        }
    }
}
