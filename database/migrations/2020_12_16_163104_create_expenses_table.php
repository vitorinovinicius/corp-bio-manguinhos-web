<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateRepaymentsTable.
 */
class CreateExpensesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('expenses', function(Blueprint $table) {
			$table->increments('id');
			$table->uuid('uuid');
			$table->unsignedInteger('user_id');
			$table->unsignedInteger('occurrence_id')->nullable();
			$table->unsignedInteger('expense_types_id');
			$table->unsignedInteger('contractor_id');
			$table->integer('category')->comment("1 - avulso / 2 -  km");
			$table->double('value');
			$table->date('date')->nullable();
			$table->string('photo_voucher')->nullable();
			$table->text('comment')->nullable();
			$table->integer('status')->default(1)->comment("1 - Pendente / 2 - Pago / 3 - Recusado / 4 - Invalidado  ");

			$table->softDeletes();

			$table->timestamps();

			$table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('restrict')
				->onUpdate('cascade');

			$table->foreign('occurrence_id')
                ->references('id')->on('occurrences')
                ->onDelete('restrict')
				->onUpdate('cascade');

			$table->foreign('expense_types_id')
                ->references('id')->on('expense_types')
                ->onDelete('restrict')
				->onUpdate('cascade');

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
		Schema::drop('expenses');
	}
}
