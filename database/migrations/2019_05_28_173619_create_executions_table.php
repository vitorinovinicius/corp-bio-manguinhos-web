<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateExecutionsTable.
 */
class CreateExecutionsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('executions', function(Blueprint $table) {
            $table->increments('id');
            $table->uuid('uuid');
            $table->unsignedInteger('occurrence_id')->unique();
            $table->text('observacao')->nullable();

            $table->timestamps();

            $table->index(["occurrence_id"], 'fk_executions_occurrences1_idx');

            $table->foreign('occurrence_id', 'fk_executions_occurrences1_idx')
                ->references('id')->on('occurrences')
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
		Schema::drop('executions');
	}
}
