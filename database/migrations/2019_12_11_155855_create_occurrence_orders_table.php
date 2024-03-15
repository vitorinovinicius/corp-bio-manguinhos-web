<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateOccurrenceOrdersTable.
 */
class CreateOccurrenceOrdersTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('occurrence_orders', function(Blueprint $table) {
			$table->increments('id');
			$table->uuid('uuid');
			$table->unsignedInteger('operator_id');
            $table->integer('flag');
			$table->date('flag_date'); 
			$table->timestamps();
			
			$table->index(["operator_id"], 'fk_occurrence_orders_users1_idx');
			$table->unique(["id"], 'id_UNIQUE');

			$table->foreign('operator_id', 'fk_occurrence_orders_users1_idx')
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
		Schema::drop('occurrence_orders');
	}
}
