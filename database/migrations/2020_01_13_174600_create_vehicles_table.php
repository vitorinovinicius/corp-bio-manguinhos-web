<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVehiclesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('uuid');
            $table->unsignedInteger('contractor_id');
            $table->integer("year");
            $table->date('document_date');
            $table->date('due_date');
            $table->string('placa');
            $table->string('chassi');
            $table->string('brand');
            $table->string('model');
            $table->integer('type')->comment("1 - carro; 2 - moto");

            $table->timestamps();

            $table->index(["contractor_id"], 'fk_vehicles_contractor1_idx');
            $table->unique(["id"], 'id_UNIQUE');

            $table->unique(["uuid"], 'vehicles_uuid_unique');

            $table->foreign('contractor_id', 'fk_vehicles_contractor1_idx')
                ->references('id')->on('contractors')
                ->onDelete('cascade')
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
        Schema::dropIfExists('vehicles');
    }
}
