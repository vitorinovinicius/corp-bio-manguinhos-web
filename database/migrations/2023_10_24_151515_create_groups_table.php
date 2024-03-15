<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateGroupsTable.
 */
class CreateGroupsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('groups', function(Blueprint $table) {
            $table->increments('id');
			$table->uuid('uuid');
			$table->string('name');
			$table->string('description');

			$table->unsignedInteger('user_id')->comment('Cliente responsavel pelo grupo');
            $table->index('user_id');
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('restrict')
                ->onUpdate('cascade');
				
			$table->unsignedInteger('contractor_id');
            $table->index('contractor_id');
            $table->foreign('contractor_id')
                ->references('id')
                ->on('contractors')
                ->onDelete('restrict')
                ->onUpdate('cascade');
				
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
		Schema::drop('groups');
	}
}
