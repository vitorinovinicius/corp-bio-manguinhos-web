<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('corpos', function(Blueprint $table) {
            $table->increments('id');			
            $table->unsignedInteger('formulario_id')->nullable();
			$table->uuid('uuid');
			$table->text('corpo')->nullable();

            $table->timestamps();
            $table->softDeletes();

			$table->index(["formulario_id"], 'fk_corpo_formulario_id_idx');
            $table->foreign('formulario_id','fk_corpo_formulario_id_idx')
                ->references('id')->on('corpos')
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
		Schema::drop('corpos');
	}
};
