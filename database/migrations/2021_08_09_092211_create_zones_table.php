<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateZonesTable.
 */
class CreateZonesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('zones', function(Blueprint $table) {
            $table->increments('id');
            $table->uuid('uuid');
            $table->string("zone");
			$table->unsignedInteger('contractor_id');

            $table->timestamps();

			$table->index('contractor_id');

            $table->unique('id');

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
		Schema::drop('zones');
	}
}
