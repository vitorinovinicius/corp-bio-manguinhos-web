<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChecklistVehicleItensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('checklist_vehicle_itens', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('uuid');
            $table->integer('type_id')->comment('1 - Carro - 2 - Moto - 3 Ambos');
            $table->string('descricao')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('checklist_vehicle_itens');
    }
}
