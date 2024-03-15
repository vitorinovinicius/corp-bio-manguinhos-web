<?php

    namespace App\Models;

    use App\Traits\Multitenantable;
    use App\Traits\Uuids;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\SoftDeletes;
    use Illuminate\Support\Facades\Auth;
    use Prettus\Repository\Contracts\Transformable;
    use Prettus\Repository\Traits\TransformableTrait;
    use Spatie\Activitylog\Traits\LogsActivity;

    /**
     * Class OccurrenceClient.
     *
     * @package namespace App\Models;
     */
    class OccurrenceClient extends Model implements Transformable
    {
        use TransformableTrait;
        use Uuids;
        use SoftDeletes;
        use LogsActivity;
        use Multitenantable;

        protected $fillable = [
            'name',
            'client_number',
            'cpf_cnpj',
            'email',
            'address',
            'number',
            'cep',
            'district',
            'city',
            'uf',
            'complement',
            'reference',
            'status',
            'contractor_id',
            'lat',
            'lng',
            'zone_id',
            'group_id',
        ];

        public function occurrences()
        {
            return $this->hasMany(Occurrence::class, 'occurrence_client_id');
        }

        public function occurrences_paginate()
        {
            if (\Artesaos\Defender\Facades\Defender::hasRole('superuser')) {
                return $this->hasMany(Occurrence::class, 'occurrence_client_id')->orderBy("id", "desc");
            } else {
                return $this->hasMany(Occurrence::class, 'occurrence_client_id')->where('contractor_id', '=', Auth::user()->contractor_id)->orderBy("id", "desc");
            }

        }

        public function occurrence_client_phones()
        {
            return $this->hasMany(OccurrenceClientPhone::class, 'occurrence_client_id');
        }

        public function sms()
        {
            return $this->hasMany(Sms::class, 'occurrence_client_id');
        }

        public function contractor()
        {
            return $this->belongsTo(Contractor::class);
        }

        public function planOccurrences()
        {
            return $this->hasMany(PlanOccurrence::class,'occurrence_client_id');
        }

        public function zone()
        {
            return $this->belongsTo(Zone::class, 'zone_id');
        }

        public function users()
        {
            return $this->belongsToMany(User::class);
        }

        public function tickets()
        {
            return $this->hasMany(Ticket::class);
        }

        public function group()
        {
            return $this->belongsTo(Group::class);
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
