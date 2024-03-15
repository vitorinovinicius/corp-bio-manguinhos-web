<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlanOccurrencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plan_occurrences', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('uuid');
            $table->date('date_begin');
            $table->date('date_finish')->nullable();
            $table->boolean('status')->default(1);
            $table->unsignedInteger('occurrence_type_id');
            $table->unsignedInteger('occurrence_client_id');
            $table->unsignedInteger('contractor_id')->nullable();
            $table->unsignedInteger('operator_id')->nullable();
            $table->boolean('weekend')->nullable();
            $table->integer('schedule')->nullable()->comment('Define de quanto em quanto tempo será criado a os. Tempo em dias ');
            $table->string('description')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(["occurrence_type_id"], 'fk_plan_occurrences_occurrence_types1_idx');
            $table->foreign('occurrence_type_id','fk_plan_occurrences_occurrence_types1_idx')
                ->references('id')->on('occurrence_types')
                ->onDelete('restrict')
                ->onUpdate('cascade');

            $table->index(["occurrence_client_id"], 'fk_plan_occurrences_occurrence_clients1_idx');
            $table->foreign('occurrence_client_id','fk_plan_occurrences_occurrence_clients1_idx')
                ->references('id')->on('occurrence_clients')
                ->onDelete('restrict')
                ->onUpdate('cascade');

            $table->index(["operator_id"], 'fk_plan_occurrences_users1_idx');
            $table->foreign('operator_id','fk_plan_occurrences_users1_idx')
                ->references('id')->on('users')
                ->onDelete('restrict')
                ->onUpdate('cascade');

            $table->index(["contractor_id"], 'fk_plan_occurrences_contractors1_idx');
            $table->foreign('contractor_id','fk_plan_occurrences_contractors1_idx')
                ->references('id')->on('contractors')
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
        Schema::dropIfExists('plan_occurrences');
    }
}
