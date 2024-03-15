<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateTicketTypeSectionFieldsTable.
 */
class CreateTicketTypeSectionFieldsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ticket_type_section_fields', function(Blueprint $table) {
            $table->increments('id');
			$table->uuid('uuid');
            $table->string('code')->nullable();
            $table->text('acceptance_criteria')->nullable();
            $table->text('item_inspection')->nullable();
            $table->boolean('status')->default(1);
            $table->tinyInteger('type_field')->comments('
                1 = Checkbox, 
                2 = Texto, 
                3 = Radio, 
                4 = Numero, 
                5 = Imagem
            ');
            $table->string('name')->nullable();
            $table->text('description')->nullable();
            $table->string('list')->nullable();
            $table->string('value')->nullable();
            $table->boolean('required')->default(0);
            $table->boolean('required_photo')->default(0);
            $table->tinyInteger('is_photo')->default(0);
            $table->tinyInteger('min_photo')->default(0);
			
			$table->unsignedInteger('contractor_id');
            $table->index('contractor_id');
            $table->foreign('contractor_id')
			->references('id')
                ->on('contractors')
                ->onDelete('restrict')
                ->onUpdate('cascade');
				
				$table->unsignedInteger('ticket_type_section_id');
				$table->index('ticket_type_section_id');
				$table->foreign('ticket_type_section_id')
				->references('id')
				->on('ticket_type_sections')
				->onDelete('restrict')
				->onUpdate('cascade');				
				
				$table->timestamps();
				$table->softDeletes();
				
				
			});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('ticket_type_section_fields');
	}
}
