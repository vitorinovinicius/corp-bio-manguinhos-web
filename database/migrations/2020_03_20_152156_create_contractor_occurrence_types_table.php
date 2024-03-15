<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateContractorOccurrenceTypesTable.
 */
class CreateContractorOccurrenceTypesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('contractor_occurrence_types', function(Blueprint $table) {
            $table->increments('id');
            $table->uuid('uuid');
            $table->unsignedInteger('contractor_id');
            $table->unsignedInteger('occurrence_type_id');
            $table->integer('capacity');
            $table->timestamps();
            $table->softDeletes();

            $table->index(["contractor_id"], 'fk_contractor_occurrence_types_contractors1_idx');
            $table->index(["occurrence_type_id"], 'fk_contractor_occurrence_types_occurrence_types1_idx');

            $table->foreign('contractor_id', 'fk_contractor_occurrence_types_contractors1_idx')
                ->references('id')->on('contractors')
                ->onDelete('restrict')
                ->onUpdate('cascade');


            $table->foreign('occurrence_type_id', 'fk_contractor_occurrence_types_occurrence_types1_idx')
                ->references('id')->on('occurrence_types')
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
		Schema::drop('contractor_occurrence_types');
	}
}
