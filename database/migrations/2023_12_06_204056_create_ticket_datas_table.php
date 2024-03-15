<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateTicketDatasTable.
 */
class CreateTicketDatasTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ticket_data', function(Blueprint $table) {
            $table->increments('id');
			$table->uuid('uuid');
			$table->text('data');

			$table->unsignedInteger('ticket_id');
            $table->index('ticket_id');
            $table->foreign('ticket_id')
			->references('id')
                ->on('tickets')
                ->onDelete('restrict')
                ->onUpdate('cascade');

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
		Schema::drop('ticket_datas');
	}
}
