<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChecklistVehicleBasicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('checklist_vehicle_basics', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('uuid');
            $table->integer('type_id')->comment('1 - Carro - 2 - Moto');
            $table->unsignedInteger('contractor_id');
            $table->unsignedInteger('condutor_id');
            $table->unsignedInteger('vehicle_id');
            $table->string('avaliador');
            $table->string('placa')->nullable();

            $table->string('check_in_lat')->nullable();
            $table->string('check_in_long')->nullable();
            $table->dateTime('check_in_date')->nullable();
            $table->dateTime('finish_date')->nullable();

            $table->timestamps();

            $table->index(["condutor_id"]);

            $table->foreign('condutor_id')
                ->references('id')->on('users')
                ->onDelete('restrict')
                ->onUpdate('cascade');

            $table->index(["contractor_id"]);

            $table->foreign('contractor_id')
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
        Schema::dropIfExists('checklist_vehicle_basics');
    }
}
