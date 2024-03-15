<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateSmsTable.
 */
class CreateLogLocalsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('log_locals', function(Blueprint $table) {
            $table->increments('id');
            $table->uuid('uuid');
            $table->string("username")->nullable();
            $table->text('error')->nullable();
            $table->string("device_version_number")->nullable();
            $table->string("base_os")->nullable();
            $table->string("codename")->nullable();
            $table->string("version_sdk_int")->nullable();
            $table->string("version_release")->nullable();
            $table->string("product")->nullable();
            $table->string("last_size")->nullable();
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
		Schema::drop('log_locals');
	}
}
