<?php

namespace App\Models;

use App\Traits\Multitenantable;
use BaoPham\DynamoDb\DynamoDbModel;
use Illuminate\Notifications\Notifiable;


class OccurrenceDynamo extends DynamoDbModel
{
    use Notifiable;
    use Multitenantable;

//    protected $table = "centralsystem_fsm_homologacao";
    protected $table;
    protected $primaryKey = ['occurrence_uuid'];
    protected $guarded = ['occurrence_uuid'];
    protected $dynamoDbIndexKeys = [
        'occurrence_uuid-index' => [
            'hash' => 'occurrence_uuid',
        ],
    ];

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    protected $fillable = [
        "occurrence_uuid",
        "occurrence_id",
        "contractor_id",
        "json",
        "created_at",
        "updated_at",
    ];

    public function __construct()
    {
        $this->table = env("DYBAMODB_TABLE","centralsystem_fsm_homologacao");
    }


    public function occurrence()
    {
        return $this->belongsTo(Occurrence::class,"occurrence_id");
    }
}
