<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateFinishWorkDaysTable.
 */
class CreateFinishWorkDaysTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('finish_work_days', function(Blueprint $table) {
            $table->increments('id');
            $table->uuid('uuid');

            $table->unsignedInteger('operator_id');
            $table->unsignedInteger('contractor_id');
            $table->integer('status');
            $table->longText('ocurrences_report');
            $table->string('date_record');

            $table->timestamps();
            $table->softDeletes();
            $table->index(["operator_id"], 'fk_finish_work_days_users1_idx');
            $table->index(["contractor_id"], 'fk_finish_work_days_contractors1_idx');


            $table->foreign('operator_id', 'fk_finish_work_days_users1_idx')
                ->references('id')->on('users')
                ->onDelete('restrict')
                ->onUpdate('cascade');

            $table->foreign('contractor_id', 'fk_finish_work_days_contractors1_idx')
                ->references('id')->on('contractors')
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
		Schema::drop('finish_work_days');
	}
}
