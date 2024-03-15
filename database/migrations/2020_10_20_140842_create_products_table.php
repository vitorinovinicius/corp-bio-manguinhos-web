<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateProductsTable.
 */
class CreateProductsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('products', function(Blueprint $table) {
			$table->increments('id');
			$table->uuid('uuid');
			$table->unsignedInteger('contractor_id');
			$table->string('name');
			$table->string('description');
			$table->float('value', 10,2);
			$table->integer('amount');
			$table->integer('status');

			$table->timestamps();
			$table->softDeletes();

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
		Schema::drop('products');
	}
}
