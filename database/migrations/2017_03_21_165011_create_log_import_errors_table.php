<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLogImportErrorsTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('log_import_errors', function(Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('contractor_id');
            $table->uuid('uuid')->unique();

            $table->char('log_import_id');
            $table->integer('line_number');
            $table->text('line_detail');
            $table->text('error_message');

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
		Schema::drop('log_import_errors');
	}

}
