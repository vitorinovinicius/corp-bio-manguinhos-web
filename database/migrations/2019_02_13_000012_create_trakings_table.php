<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrakingsTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'trakings';

    /**
     * Run the migrations.
     * @table trakings
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
            $table->unsignedInteger('user_id')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->string('tipo_conexao')->nullable();
            $table->string('isConnect')->nullable();
            $table->string('checkin_date')->nullable();
            $table->string('device')->nullable();
            $table->string('device_version')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->index(["user_id"], 'fk_traking_users1_idx');

            $table->unique(["uuid"], 'trakings_uuid_unique');

            $table->unique(["id"], 'id_UNIQUE');


            $table->foreign('user_id', 'fk_traking_users1_idx')
                ->references('id')->on('users')
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
