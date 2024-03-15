<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoutingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('routings', function (Blueprint $table) {
            $table->increments('id');
			$table->uuid('uuid');
			$table->unsignedInteger('contractor_id')->nullable();
			$table->unsignedInteger('operator_id');
            $table->dateTime('routing_date');
            $table->text('addresses');
            $table->text('routed_addresses');

            $table->softDeletes();

			$table->timestamps();

			$table->foreign('contractor_id')
			->references('id')->on('contractors')
			->onDelete('restrict')
			->onUpdate('cascade');

			$table->foreign('operator_id')
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
        Schema::dropIfExists('routings');
    }
}
