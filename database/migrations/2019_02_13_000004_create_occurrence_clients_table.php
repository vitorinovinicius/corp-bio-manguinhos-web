<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOccurrenceClientsTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'occurrence_clients';

    /**
     * Run the migrations.
     * @table occurrence_clients
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
            $table->integer('client_number')->nullable();
            $table->string('name');
            $table->string('cpf_cnpj')->nullable();
            $table->string('email')->nullable();
            $table->string('address')->nullable();
            $table->string('number')->nullable();
            $table->string('cep')->nullable();
            $table->string('district')->nullable();
            $table->string('city')->nullable();
            $table->string('uf')->nullable();
            $table->string('complement')->nullable();
            $table->string('reference')->nullable();
            $table->integer('status')->nullable()->default('1')->comment('1 - Ok / 2 - Prospecto para avaliar');

            $table->timestamps();
            $table->softDeletes();

            $table->unique(["uuid"], 'occurrence_clients_uuid_unique');

            $table->unique(["id"], 'id_UNIQUE');

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
