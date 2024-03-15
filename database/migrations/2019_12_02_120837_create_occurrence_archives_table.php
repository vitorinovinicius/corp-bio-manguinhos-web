<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateOccurrenceArchivesTable.
 */
class CreateOccurrenceArchivesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('occurrence_archives', function(Blueprint $table) {
            $table->increments('id');
            $table->uuid('uuid');
            $table->unsignedInteger('occurrence_id');
            $table->unsignedInteger('user_id');
            $table->string('url')->nullable();
            $table->string('name_original')->nullable();
            $table->string('name')->nullable();
            $table->integer('size')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->index(["occurrence_id"], 'fk_occurrence_archives_occurrences1_idx');

            $table->index(["user_id"], 'fk_occurrence_archives_users1_idx');

            $table->unique(["id"], 'id_UNIQUE');

            $table->foreign('occurrence_id', 'fk_occurrence_archives_occurrences1_idx')
                ->references('id')->on('occurrences')
                ->onDelete('restrict')
                ->onUpdate('cascade');

            $table->foreign('user_id', 'fk_occurrence_archives_users1_idx')
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
		Schema::drop('occurrence_archives');
	}
}
