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
		Schema::create('emails', function(Blueprint $table) {
            $table->increments('id');
            $table->uuid('uuid');
            $table->unsignedInteger('remetente_id')->nullable();
            $table->unsignedInteger('destinatario_id')->nullable();
            $table->unsignedInteger('secao_formulario_id')->nullable();
            $table->string('corpo')->nullable();

			$table->index(["remetente_id"], 'fk_emails_remetente_idx');
			$table->index(["destinatario_id"], 'fk_emails_destinatario_idx');
			$table->index(["secao_formulario_id"], 'fk_emails_secao_formulario_idx');
			
            $table->foreign('secao_formulario_id','fk_emails_secao_formulario_idx')
                ->references('id')->on('secao_formularios')
                ->onDelete('restrict')
                ->onUpdate('cascade');

            $table->foreign('remetente_id','fk_emails_remetente_idx')
                ->references('id')->on('users')
                ->onDelete('restrict')
                ->onUpdate('cascade');

            $table->foreign('destinatario_id','fk_emails_destinatario_idx')
                ->references('id')->on('users')
                ->onDelete('restrict')
                ->onUpdate('cascade');

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
		Schema::drop('emails');
	}
};
