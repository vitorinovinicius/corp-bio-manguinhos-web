<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOccurrenceClientPhonesTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'occurrence_client_phones';

    /**
     * Run the migrations.
     * @table occurrence_client_phones
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->uuid('uuid');
            $table->unsignedInteger('occurrence_client_id');
            $table->string('phone');
            $table->string('obs')->nullable();

            $table->timestamps();

            $table->index(["occurrence_client_id"], 'fk_occurrence_client_phones_occurrence_clients1_idx');

            $table->unique(["id"], 'id_UNIQUE');

            $table->unique(["uuid"], 'occurrence_client_phones_uuid_unique');


            $table->foreign('occurrence_client_id', 'fk_occurrence_client_phones_occurrence_clients1_idx')
                ->references('id')->on('occurrence_clients')
                ->onDelete('restrict')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
     public function down()
     {
       Schema::dropIfExists($this->set_schema_table);
     }
}
