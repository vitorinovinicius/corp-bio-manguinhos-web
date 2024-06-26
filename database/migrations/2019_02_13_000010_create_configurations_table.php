<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConfigurationsTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'configurations';

    /**
     * Run the migrations.
     * @table configurations
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
            $table->unsignedInteger('setor_id')->nullable();
            $table->string('config_key')->nullable();
            $table->string('config_value')->nullable();
            $table->string('description')->nullable();
            $table->integer('tipo')->nullable()->default('1')->comment('1 - Usuario , 2 - Sistema');
            $table->integer('tipo_user')->nullable()->default('1')->comment('1 - Empreiteira');
            $table->integer('tipo_form')->nullable()->default('1')->comment('1 - Select, 2 Text');

            $table->timestamps();
            $table->softDeletes();

            $table->index(["setor_id"], 'fk_configurations_setor_idx');

            $table->unique(["id"], 'id_UNIQUE');


            $table->foreign('setor_id', 'fk_configurations_setor_idx')
                ->references('id')->on('setores')
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
