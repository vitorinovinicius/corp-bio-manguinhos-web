<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLogImportsTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('log_imports', function(Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('contractor_id')->nullable();
            $table->uuid('uuid')->unique();

            $table->unsignedInteger('user_id');
            $table->string('name_archive');
            $table->string('original_name');
            $table->string('url')->nullable();
            $table->integer('qtd_error')->nullable();
            $table->integer('qtd_success')->nullable();
            $table->integer('lines')->nullable();
            $table->text('archive_path')->nullable();
            $table->date('schedules_date')->nullable();

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
		Schema::drop('log_imports');
	}

}
