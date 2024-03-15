<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateWorkdaysTable.
 */
class CreateWorkdaysTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('workdays', function(Blueprint $table) {
            $table->increments('id');
			$table->uuid('uuid');
			$table->string('name');
			$table->boolean('status')->default(1);
			$table->unsignedInteger('contractor_id');
            $table->timestamps();

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
		Schema::drop('workdays');
	}
}
