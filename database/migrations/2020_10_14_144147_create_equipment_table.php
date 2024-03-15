<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateEquipmentTable.
 */
class CreateEquipmentTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('equipments', function(Blueprint $table) {
            $table->increments('id');
			$table->uuid('uuid');
			$table->string('name');
			$table->string('type')->nullable();
			$table->date('validade')->nullable();
			$table->unsignedInteger('contractor_id');
			$table->unsignedInteger('user_id')->nullable();
			$table->integer('status')->comment("1 - ativo / 2 - Inativo / 3 - Reparo");
			$table->timestamps();

			$table->foreign('user_id', 'fk_equipments_users_idx')
			->references('id')->on('users')
			->onDelete('restrict')
			->onUpdate('cascade');

			$table->foreign('contractor_id', 'fk_equipments_contractors_idx')
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
		Schema::drop('equipments');
	}
}
