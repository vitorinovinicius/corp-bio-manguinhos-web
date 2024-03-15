<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateOperatorOccurrencesTable.
 */
class CreateOperatorOccurrencesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('operator_occurrences', function(Blueprint $table) {
			$table->increments('id');
            $table->uuid('uuid');
            $table->unsignedInteger('operator_id');
			$table->unsignedInteger('occurrence_id');
			$table->date('schedule_date');            
            $table->integer('order');
			$table->integer('priority');
            $table->timestamps();

            $table->index(["occurrence_id"], 'fk_operator_occurrences_occurrences1_idx');

            $table->index(["operator_id"], 'fk_operator_occurrences_users1_idx');

            $table->unique(["id"], 'id_UNIQUE');

            $table->foreign('occurrence_id', 'fk_operator_occurrences_occurrences1_idx')
                ->references('id')->on('occurrences')
                ->onDelete('restrict')
                ->onUpdate('cascade');

            $table->foreign('operator_id', 'fk_operator_occurrences_users1_idx')
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
		Schema::drop('operator_occurrences');
	}
}
