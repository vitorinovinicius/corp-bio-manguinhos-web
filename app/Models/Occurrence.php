<?php

    namespace App\Models;

    use App\Traits\Multitenantable;
    use App\Traits\Uuids;
    use Carbon\Carbon;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\SoftDeletes;
    use Prettus\Repository\Contracts\Transformable;
    use Prettus\Repository\Traits\TransformableTrait;
    use Spatie\Activitylog\Traits\LogsActivity;

    /**
     * Class Occurrence.
     *
     * @package namespace App\Models;
     */
    class Occurrence extends Model implements Transformable
    {
        use TransformableTrait;
        use Uuids;
        use SoftDeletes;
        use LogsActivity;
        use Multitenantable;

        /**
         * The attributes that are mass assignable.
         *
         * @var array
         */
        protected $fillable = [
            'occurrence_client_id',
            'occurrence_type_id',
            'contractor_id',
            'cancelamento_status_id',
            'region_id',
            'operator_id',
            'numero_os',
            'numero_cliente',
            'schedule_date',
            'schedule_time',
            'priority',
            'obs_os',
            'assinatura',
            'check_in_lat',
            'check_in_long',
            'check_out_lat',
            'check_out_long',
            'check_in',
            'check_out',
            'date_is_received',
            'date_finish',
            'motivo_nao_realizacao',
            'order_client',
            'status',
            'download_at',
            'url',
            'approved',
            'approved_date',
            'status_sms',
            'log_import_id',
            'code_verification',
            'schedules_original',
            'total_imagens',
            'status_schedule',
            'status_schedule_date',
            'is_manual',
            'organizacao',
            'organizacao_id',
            'signature_type',
            'status_faturado',
            'covid19_quest',
            'order_flag',
            'os_before_id',
            'obs_empreiteira',
            'manual_execution',
            'execute_by',
            'evaluation',
            'send_mail',
            'shift',
            'plan_occurrence_id',
            'url_pdf',
            'url_pdf_image',
            'ticket_id',
            'json'

        ];

        public function import()
        {
            return $this->belongsTo(LogImport::class, 'log_import_id');
        }

        public function region()
        {
            return $this->belongsTo(Region::class, 'region_id');
        }

        public function cancelamento_status()
        {
            return $this->belongsTo(CancelamentoStatus::class, 'cancelamento_status_id');
        }

        public function operator()
        {
            return $this->belongsTo(User::class, 'operator_id');
        }

        public function executeBy()
        {
            return $this->belongsTo(User::class, 'execute_by');
        }

        public function contractor()
        {
            return $this->belongsTo(Contractor::class, 'contractor_id');
        }

        public function occurrence_type()
        {
            return $this->belongsTo(OccurrenceType::class, 'occurrence_type_id');
        }

        public function occurrence_client()
        {
            return $this->belongsTo(OccurrenceClient::class, 'occurrence_client_id');
        }

        public function statusCancel()
        {
            return $this->hasOne(CancelamentoStatus::class, 'id', 'nao_realizado');
        }

        public function nao_realizado_status()
        {
            return $this->hasOne(CancelamentoStatus::class, 'id', 'cancelamento_status_id');
        }

        public function occurrence_images()
        {
            return $this->hasMany(OccurrenceImage::class, 'occurrence_id');
        }

        public function occurrence_data_basic()
        {
            return $this->hasOne(OccurrenceDataBasic::class, 'occurrence_id');
        }

        public function reallocation()
        {
            return $this->hasMany(Reallocation::class, 'occurrence_id');
        }

        public function moves()
        {
            return $this->hasMany(Move::class, 'occurrence_id')->orderBy('check_in', 'asc');
        }

        public function occurrence_form_fields()
        {
            return $this->hasMany(OccurrenceFormField::class, 'occurrence_id');
        }

        public function form_fields()
        {
            return $this->belongsToMany(FormField::class, 'occurrence_form_fields', 'occurrence_id', 'form_field_id');
        }

        public function occurrence_data_client()
        {
            return $this->hasOne(OccurrenceDataClient::class, "occurrence_id");
        }

        public function execution()
        {
            return $this->hasOne(Execution::class, 'occurrence_id');
        }

        public function smses()
        {
            return $this->hasMany(Sms::class, 'occurrence_id');
        }

        public function sms()
        {
            return $this->hasMany(Sms::class, 'occurrence_id')->get()->last();
        }

        public function financial()
        {
            return $this->hasOne(Financial::class, 'occurrence_id');
        }

        public function occurrence_archives()
        {
            return $this->hasMany(OccurrenceArchive::class, 'occurrence_id');
        }

        public function alerts()
        {
            return $this->hasMany(Alert::class, 'occurrence_id');
        }

        public function occurrence_before()
        {
            return $this->hasOne(Occurrence::class, 'id', 'os_before_id');
        }

        public function occurrence_childs()
        {
            return $this->hasMany(Occurrence::class, 'os_before_id');
        }

        public function model_evaluation()
        {
            return $this->hasOne(Evaluation::class, 'occurrence_id');
        }

        public function planOccurrence()
        {
            return $this->belongsTo(PlanOccurrence::class);
        }

        public function pdfs()
        {
            return $this->hasMany(OccurrencePdf::class, 'occurrence_id');
        }

        public function ticket()
        {
            return $this->belongsTo(Ticket::class);
        }

        public function getStatus()
        {
            //1 - Pendente / 2 - Realizada / 3 - Não realizada / 4 - Cancelada
            if ($this->status == 1) {
                return "Aberta";
            } else if ($this->status == 2) {
                return "Realizada";
            } else if ($this->status == 3) {
                return "Não realizada";
            } else if ($this->status == 4) {
                return "Cancelada";
            }
        }

        public function status_sms()
        {
            //0 - Não enviado / 1 - Enviado com sucesso / 2 - Erro ao enviar
            if ($this->status_sms == 0) {
                return "-";
            } else if ($this->status_sms == 1) {
                return "Enviado";
            } else if ($this->status_sms == 2) {
                return "Erro ao enviar";
            } else if ($this->status_sms == 3) {
                return "Sem celular";
            } else {
                return "-";
            }
        }

        function priority()
        {
            switch ($this->priority) {
                case 1  :
                    $priority = "Baixa";
                    break;
                case 2  :
                    $priority = "Normal";
                    break;
                case 3  :
                    $priority = "Alta";
                    break;
                case 4  :
                    $priority = "Urgente";
                    break;
                case 5  :
                    $priority = "Especial";
                    break;
                case 6  :
                    $priority = "Judicial";
                    break;
                default :
                    $priority = "-";
                    break;
            }
            return $priority;
        }

        function shift()
        {
            switch ($this->shift) {
                case 1  :
                    $shift = "Manhã";
                    break;
                case 2  :
                    $shift = "Tarde";
                    break;
                case 3  :
                    $shift = "Noite";
                    break;
                default :
                    $shift = "-";
                    break;
            }
            return $shift;
        }


        public function statusLabel()
        {
            if ($this->status == 1) {
                return "btn-primary";
            } else if ($this->status == 2) {
                return "btn-success";
            } else if ($this->status == 3) {
                return "btn-warning";
            } else if ($this->status == 4) {
                return "btn-danger";
            } else if ($this->status == 5) {
                return "btn-danger";
            }

            //"label-warning" : "label-primary" --
        }

        public function financialStatus()
        {
            /*
                 0 - Pendente
                 1 - Aprovado
                 2 - Reprovado
                 3 - Solicitado ajuste
                 4 - Ajuste feito pela ECC
             */

            switch ($this->approved) {
                case "0":
                    $tipo = "Pendente";
                    break;
                case "1":
                    $tipo = "Aprovado";
                    break;
                case "2":
                    $tipo = "Reprovado";
                    break;
                case "3":
                    $tipo = "Solicitado ajuste";
                    break;
                case "4":
                    $tipo = "Ajustado pela Empreiteira";
                    break;
            }
            return $tipo;
        }

        public function financialStatusLabel()
        {
            /*
                 0 - Pendente
                 1 - Aprovado
                 2 - Reprovado
                 3 - Solicitado ajuste
                 4 - Ajuste feito pela ECC
             */

            switch ($this->approved) {
                case "0":
                    $tipo = "btn-primary";
                    break;
                case "1":
                    $tipo = "btn-success";
                    break;
                case "2":
                    $tipo = "btn-danger";
                    break;
                case "3":
                    $tipo = "btn-warning";
                    break;
                case "4":
                    $tipo = "btn-info";
                    break;
            }
            return $tipo;
        }

        public function schedule_date()
        {
            return Carbon::parse($this->schedule_date)->format("d/m/Y");
        }

        public function dataAgendamentoFormart()
        {
            return Carbon::parse($this->schedule_date)->format("d/m/Y") . " " . $this->schedule_time;
        }

        public function dataAgendamentoFormartJS()
        {
            if($this->schedule_time){
                $shift = $this->schedule_time;
            } elseif ($this->shift == 1) { //Manhã
                $shift = " 08:00:00";
            } elseif ($this->shift == 2) { //tarde
                $shift = " 12:00:00";
            } elseif ($this->shift == 3) { //noite
                $shift = " 18:00:00";
            } else {
                $shift = " 00:00:00";
            }
            return Carbon::parse($this->schedule_date . " " . $shift)->format("Y,m,d,H,i,s");
        }

        public function dataAgendamentoFormartJSLimite()
        {
            if ($this->average_time && $this->schedule_time) {
                $schedule_time = Carbon::createFromFormat("H:i:s", $this->schedule_time);

                $time = explode(":", $this->average_time);
                $hour = $time[0];
                $minute = $time[1];

                $date_final = $schedule_time->addHours($hour)->addMinutes($minute)->format("H:i:s");

                return Carbon::parse($this->schedule_date . " " . $date_final)->format("Y,m,d,H,i,s");
            } elseif (!$this->average_time && $this->schedule_time) {
                return Carbon::parse($this->schedule_date . " " . $this->schedule_time)->addHour()->format("Y,m,d,H,i,s");
            } else {

                if ($this->shift == 1) { //Manhã
                    $shift = " 08:00:00";
                } elseif ($this->shift == 2) { //tarde
                    $shift = " 12:00:00";
                } elseif ($this->shift == 3) { //noite
                    $shift = " 18:00:00";
                } else {
                    $shift = " 00:00:00";
                }

                return Carbon::parse($this->schedule_date . " " . $shift)->addHour()->format("Y,m,d,H,i,s");
            }
        }

        public function interferences()
        {
            return $this->belongsToMany(Interference::class, 'occurrence_interference');
        }

        public function calculaTempo()
        {
            return (!empty($this->check_in && !empty($this->check_out))) ? calcula_minutos($this->check_in, $this->check_out) : "-";
        }

        public function forms()
        {
            return $this->belongsToMany(Form::class, 'occurrence_forms', 'occurrence_id', 'form_id');
        }

        public function occurrence_forms()
        {
            return $this->hasMany(OccurrenceForm::class, 'occurrence_id');
        }


        public function occurrence_dynamo_last()
        {
            $occurrenceDynamo = new OccurrenceDynamo();
            $occurrenceDynamo = $occurrenceDynamo->where("occurrence_uuid", $this->uuid)->orderBy("created_at", "desc")->first();
            return $occurrenceDynamo;
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
    }
