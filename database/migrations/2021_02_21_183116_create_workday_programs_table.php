<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateWorkdayProgramsTable.
 */
class CreateWorkdayProgramsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('workday_programs', function(Blueprint $table) {
            $table->increments('id');
			$table->uuid('uuid');
			$table->unsignedInteger('workday_id');
			$table->integer('day');
			$table->integer('hour');
            $table->timestamps();

			$table->foreign('workday_id')
                ->references('id')->on('workdays')
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
		Schema::drop('workday_programs');
	}
}
