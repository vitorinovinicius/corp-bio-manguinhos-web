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
		Schema::create('formularios', function(Blueprint $table) {
            $table->increments('id');			
            $table->unsignedInteger('setor_id');
			$table->uuid('uuid');
			$table->string('titulo')->nullable();
			$table->string('sub_titulo')->nullable();
			$table->integer('limite_caracteres')->nullable();
			$table->date('ANO')->nullable();

            $table->timestamps();
            $table->softDeletes();

			$table->index(["setor_id"], 'fk_formulario_setor_id_idx');
            $table->foreign('setor_id','fk_formulario_setor_id_idx')
                ->references('id')->on('teams')
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
		Schema::drop('formularios');
	}
};

