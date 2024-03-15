<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateTicketTypeSectionsTable.
 */
class CreateTicketTypeSectionsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ticket_type_sections', function(Blueprint $table) {
            $table->increments('id');
			$table->uuid('uuid');
			$table->string('name');
			$table->string('description');
            $table->timestamps();

			$table->unsignedInteger('contractor_id');
            $table->index('contractor_id');
            $table->foreign('contractor_id')
                ->references('id')
                ->on('contractors')
                ->onDelete('restrict')
                ->onUpdate('cascade');

			$table->unsignedInteger('ticket_type_id');
			$table->index('ticket_type_id');
			$table->foreign('ticket_type_id')
				->references('id')
				->on('ticket_types')
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
		Schema::drop('ticket_type_sections');
	}
}
