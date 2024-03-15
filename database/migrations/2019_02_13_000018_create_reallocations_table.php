<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReallocationsTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'reallocations';

    /**
     * Run the migrations.
     * @table reallocations
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
            $table->unsignedInteger('occurrence_id');
            $table->unsignedInteger('operator_id');
            $table->integer('status')->nullable()->comment('0 - Não notificado | 1 - Notificado');

            $table->timestamps();
            $table->softDeletes();

            $table->index(["operator_id"], 'fk_reallocations_users1_idx');

            $table->index(["occurrence_id"], 'fk_reallocations_occurrences1_idx');

            $table->unique(["uuid"], 'reallocations_uuid_unique');


            $table->foreign('occurrence_id', 'fk_reallocations_occurrences1_idx')
                ->references('id')->on('occurrences')
                ->onDelete('restrict')
                ->onUpdate('cascade');

            $table->foreign('operator_id', 'fk_reallocations_users1_idx')
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
