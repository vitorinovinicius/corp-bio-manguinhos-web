<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateTicketTypesTable.
 */
class CreateTicketTypesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ticket_types', function(Blueprint $table) {
            $table->increments('id');
			$table->uuid('uuid');
			$table->string('name');
			$table->string('description');
			
			$table->unsignedInteger('group_id');
            $table->index('group_id');
            $table->foreign('group_id')
                ->references('id')
                ->on('groups')
                ->onDelete('restrict')
                ->onUpdate('cascade');

			$table->unsignedInteger('contractor_id');
            $table->index('contractor_id');
            $table->foreign('contractor_id')
                ->references('id')
                ->on('contractors')
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
		Schema::drop('ticket_types');
	}
}
