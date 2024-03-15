<?php

    namespace App\Models;

    use App\Traits\Multitenantable;
    use Illuminate\Database\Eloquent\Model;
    use Prettus\Repository\Contracts\Transformable;
    use Prettus\Repository\Traits\TransformableTrait;
    use App\Traits\Uuids;
    use Illuminate\Database\Eloquent\SoftDeletes;

    /**
     * Class PlanOccurrences.
     *
     * @package namespace App\Models;
     */
    class PlanOccurrence extends Model implements Transformable
    {
        use Uuids;
        use SoftDeletes;
        use TransformableTrait;
        use Multitenantable;

        /**
         * The attributes that are mass assignable.
         *
         * @var array
         */
        protected $fillable = [
            'contractor_id',
            'occurrence_type_id',
            'occurrence_client_id',
            'operator_id',
            'date_begin',
            'date_finish',
            'status',
            'weekend',
            'description',
            'schedule',
        ];

        public function occurrenceType()
        {
            return $this->belongsTo(OccurrenceType::class, 'occurrence_type_id');
        }

        public function OccurrenceClient()
        {
            return $this->belongsTo(OccurrenceClient::class, 'occurrence_client_id');
        }

        public function operator()
        {
            return $this->belongsTo(User::class, 'operator_id');
        }

        public function contractor()
        {
            return $this->belongsTo(Contractor::class, 'contractor_id');
        }

        public function occurrences()
        {
            return $this->hasMany(Occurrence::class, 'plan_occurrence_id');
        }

        public function date_begin()
        {
            return $this->date_begin ? date('d/m/Y', strtotime($this->date_begin)) : '-';
        }

        public function date_finish()
        {
            return $this->date_finish ? date('d/m/Y', strtotime($this->date_finish)) : '-';
        }

    }
