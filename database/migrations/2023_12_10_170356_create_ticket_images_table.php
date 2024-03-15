<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateTicketImagesTable.
 */
class CreateTicketImagesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ticket_images', function(Blueprint $table) {
            $table->increments('id');
			$table->uuid('uuid');
			$table->string('url');
			$table->string('reference');
			
			$table->unsignedInteger('ticket_id');
            $table->index('ticket_id');
            $table->foreign('ticket_id')
			->references('id')
                ->on('tickets')
                ->onDelete('restrict')
                ->onUpdate('cascade');

			$table->unsignedInteger('section_id');
            $table->index('section_id');
            $table->foreign('section_id')
			->references('id')
                ->on('ticket_type_sections')
                ->onDelete('restrict')
                ->onUpdate('cascade');

			$table->unsignedInteger('form_field_id');
            $table->index('form_field_id');
            $table->foreign('form_field_id')
			->references('id')
                ->on('ticket_type_section_fields')
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
		Schema::drop('ticket_images');
	}
}
