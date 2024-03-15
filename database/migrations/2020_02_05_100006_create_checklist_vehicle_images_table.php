<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChecklistVehicleImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('checklist_vehicle_images', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('uuid');
            $table->unsignedInteger('checklist_vehicle_basic_id');
            $table->string('url')->nullable();
            $table->string('reference')->nullable();
            $table->string('uuid_external')->nullable();

            $table->timestamps();

            $table->index(["uuid_external"]);
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
        Schema::dropIfExists('checklist_vehicle_images');
    }
}
