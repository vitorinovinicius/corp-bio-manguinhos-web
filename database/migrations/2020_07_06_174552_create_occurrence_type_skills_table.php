<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateOccurrenceTypeSkillsTable.
 */
class CreateOccurrenceTypeSkillsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('occurrence_type_skills', function(Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('occurrence_type_id');
            $table->unsignedInteger('skill_id');

            $table->timestamps();

            $table->foreign('occurrence_type_id', 'fk_occurrence_type_skill_occurrence_types_idx')
                ->references('id')->on('occurrence_types')
                ->onDelete('restrict')
                ->onUpdate('cascade');

            $table->foreign('skill_id', 'fk_occurrence_type_skill_skillss_idx')
                ->references('id')->on('skills')
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
		Schema::drop('occurrence_type_skills');
	}
}
