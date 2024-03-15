<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChecklistVehiclesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('checklist_vehicles', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('uuid');
            $table->unsignedInteger('checklist_vehicle_basic_id');
            $table->integer('item_id')->nullable();
            $table->integer('option_id')->default(1)
                ->comment("1 - conforme 2 - não conforme");
            $table->string('acao_recomendada')->nullable();
            $table->string('responsavel')->nullable();
            $table->string('prazo')->nullable();

            $table->timestamps();

            $table->index(["checklist_vehicle_basic_id"]);

            $table->foreign('checklist_vehicle_basic_id')
                ->references('id')->on('checklist_vehicle_basics')
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
        Schema::dropIfExists('checklist_vehicles');
    }
}
