<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateExpenseTypesTable.
 */
class CreateExpenseTypesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('expense_types', function(Blueprint $table) {
			$table->increments('id');
			$table->uuid('uuid');
			$table->string('name');
			$table->unsignedInteger('contractor_id')->nullable();
			$table->softDeletes();
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
		Schema::drop('expense_types');
	}
}
