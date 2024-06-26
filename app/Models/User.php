<?php

    namespace App\Models;

    use App\Traits\Multitenantable;
    use Artesaos\Defender\Traits\HasDefender;
    use Illuminate\Database\Eloquent\SoftDeletes;
    use Illuminate\Foundation\Auth\User as Authenticatable;
    use Laravel\Passport\HasApiTokens;
    use Illuminate\Notifications\Notifiable;
    use App\Traits\Uuids;
    use Prettus\Repository\Contracts\Transformable;
    use Prettus\Repository\Traits\TransformableTrait;

    class User extends Authenticatable implements Transformable
    {
        use TransformableTrait;
        use Notifiable;
        use Uuids;
        use HasApiTokens;
        use HasDefender;
        use SoftDeletes;
        use Multitenantable;


        protected $fillable = [
            'id',
            'uuid',
            'name',
            'email',
            'password',
            'cpf',
            'status',
        ];
        
        /**
         * The attributes that should be hidden for arrays.
         *
         * @var array
         */
        protected $hidden = ['password', 'remember_token',];

        public function secaoFormulario()
        {
            return $this->hasMany(SecaoFormulario::class);
        }

        public function role_users()
        {
            return $this->hasMany(RoleUser::class, "user_id");
        }

        public function roles()
        {
            return $this->belongsToMany(Role::class, 'role_user');
        }

        public function hasRole($roleName)
        {
            return $this->roles->contains('name', $roleName);
        }

        public function setores()
        {
            return $this->belongsToMany(Setor::class, 'user_setores');
        }

        public function user_setores()
        {
            return $this->hasMany(UserSetores::class, "user_id");
        }

        public function emailsEnviados()
        {
            return $this->hasMany(Email::class, 'remetente_id');
        }
    
        public function emailsRecebidos()
        {
            return $this->hasMany(Email::class, 'destinatario_id');
        }

        public function occurrencesDays()
        {
            $model = $this->hasMany('App\Models\Occurrence', 'operator_id');

            $scheduled_date = \Request::input('scheduled_date');
            if ($scheduled_date) {
                $explodData = explode("-", $scheduled_date);
                $explodDataIni = explode("/", trim($explodData[0]));
                $explodDataFim = explode("/", trim($explodData[1]));


                $dataIni = $explodDataIni[2] . "-" . $explodDataIni[1] . "-" . $explodDataIni[0];
                $dataFim = $explodDataFim[2] . "-" . $explodDataFim[1] . "-" . $explodDataFim[0];

                if ($dataIni != "" && $dataFim != "") {
                    $model->whereBetween('schedule_date', [$dataIni, $dataFim]);

                } else {
                    $model->where('schedule_date', '=', \Illuminate\Support\Carbon::now()->format("Y-m-d"));
                }
            } else {
                $model->where('schedule_date', '=', \Illuminate\Support\Carbon::now()->format("Y-m-d"));
            }

            $model->orderBy('order_client', "ASC");
            $model->orderBy('updated_at', "desc");

            return $model;
        }

        public function occurrencesFilterSchedule()
        {

            $model = $this->hasMany('App\Models\Occurrence', 'operator_id');

            $scheduled_date = \Request::input('scheduled_date');
            if ($scheduled_date) {
                $explodData = explode("-", $scheduled_date);
                $explodDataIni = explode("/", trim($explodData[0]));
                $explodDataFim = explode("/", trim($explodData[1]));


                $dataIni = $explodDataIni[2] . "-" . $explodDataIni[1] . "-" . $explodDataIni[0];
                $dataFim = $explodDataFim[2] . "-" . $explodDataFim[1] . "-" . $explodDataFim[0];

                if ($dataIni != "" && $dataFim != "") {
                    $model->whereBetween('schedule_date', [$dataIni, $dataFim]);

                } else {
                    $model->where('schedule_date', '=', \Illuminate\Support\Carbon::now()->format("Y-m-d"));
                }
            } else {
                $model->where('schedule_date', '=', \Illuminate\Support\Carbon::now()->format("Y-m-d"));
            }

            $model->orderBy('order_client', "ASC");
            return $model->orderBy('updated_at', "desc");
        }

        public function occurrencesDaysCheckin()
        {
            $model = $this->hasMany('App\Models\Occurrence', 'operator_id');

            $scheduled_date = \Request::input('scheduled_date');
            if ($scheduled_date) {
                $explodData = explode("-", $scheduled_date);
                $explodDataIni = explode("/", trim($explodData[0]));
                $explodDataFim = explode("/", trim($explodData[1]));


                $dataIni = $explodDataIni[2] . "-" . $explodDataIni[1] . "-" . $explodDataIni[0];
                $dataFim = $explodDataFim[2] . "-" . $explodDataFim[1] . "-" . $explodDataFim[0];

                if ($dataIni != "" && $dataFim != "") {
                    $model->whereBetween('schedule_date', [$dataIni, $dataFim]);

                } else {
                    $model->where('schedule_date', '=', \Illuminate\Support\Carbon::now()->format("Y-m-d"));
                }
            } else {
                $model->where('schedule_date', '=', \Illuminate\Support\Carbon::now()->format("Y-m-d"));
            }

            $model->where("status", "=", 2)->orderBy('check_in', "asc");

            return $model;
        }

        public function occurrencesDaysCheckout()
        {
            $model = $this->hasMany('App\Models\Occurrence', 'operator_id');

            $scheduled_date = \Request::input('scheduled_date');
            if ($scheduled_date) {
                $explodData = explode("-", $scheduled_date);
                $explodDataIni = explode("/", trim($explodData[0]));
                $explodDataFim = explode("/", trim($explodData[1]));


                $dataIni = $explodDataIni[2] . "-" . $explodDataIni[1] . "-" . $explodDataIni[0];
                $dataFim = $explodDataFim[2] . "-" . $explodDataFim[1] . "-" . $explodDataFim[0];

                if ($dataIni != "" && $dataFim != "") {
                    $model->whereBetween('schedule_date', [$dataIni, $dataFim]);

                } else {
                    $model->where('schedule_date', '=', \Illuminate\Support\Carbon::now()->format("Y-m-d"));
                }
            } else {
                $model->where('schedule_date', '=', \Illuminate\Support\Carbon::now()->format("Y-m-d"));
            }

            $model->where("status", "=", 2)->orderBy('check_out', "desc");

            return $model;

        }

        public function tracking()
        {
            return $this->hasMany('App\Models\Traking', 'user_id');
        }

        public function scopeRole($role)
        {
            return $this->whereHas('roles', function ($query) use ($role) {
                $query->where('id', $role);
            });
        }

        
        // INÍCIO HELPERS DO MODEL

        public function last_connection()
        {
            return $this->last_connection ? date('d/m/Y H:i:s', strtotime($this->last_connection)) : 'Sem registro';
        }

        public function valids()
        {
            return $this->valid ? date('d/m/Y', strtotime($this->valid)) : '';
        }

        public function manometro_validade()
        {
            return $this->manometro_validade ? date('d/m/Y', strtotime($this->manometro_validade)) : '';
        }

        public function manometro_calibracao()
        {
            return $this->manometro_calibracao ? date('d/m/Y', strtotime($this->manometro_calibracao)) : '';
        }

        public function manometro_validade_status()
        {
            if (!empty($this->manometro_validade)) {
                return ($this->manometro_validade < \Illuminate\Support\Carbon::now()->format("Y-m-d")) ? 'Vencido' : 'A vencer';
            } else {
                return "";
            }
        }

        public function analisador_validade()
        {
            return $this->analisador_validade ? date('d/m/Y', strtotime($this->analisador_validade)) : '';
        }

        public function analisador_calibracao()
        {
            return $this->analisador_calibracao ? date('d/m/Y', strtotime($this->analisador_calibracao)) : '';
        }

        public function analisador_validade_status()
        {
            if (!empty($this->analisador_validade)) {
                return ($this->analisador_validade < \Illuminate\Support\Carbon::now()->format("Y-m-d")) ? 'Vencido' : 'A vencer';
            } else {
                return "";
            }
        }

        public function cnh_expires()
        {
            return $this->cnh_expires ? date('d/m/Y', strtotime($this->cnh_expires)) : '';
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
                return 'Inclusão de Usuário';
            }

            if ($eventName == 'updated') {
                return 'Alteração de Usuário';
            }

            if ($eventName == 'deleted') {
                return 'Exclusão de Usuário';
            }

            return $eventName;
        }

        public function status()
        {
            switch ($this->status) {
                case 1: return "Habilitado"; break;

                case 2: return "Desabilitado"; break;

                default: return "-"; break;
            }
        }

    }
