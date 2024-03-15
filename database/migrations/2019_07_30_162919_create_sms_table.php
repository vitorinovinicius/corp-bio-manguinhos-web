<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateSmsTable.
 */
class CreateSmsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('sms', function(Blueprint $table) {
            $table->increments('id');
            $table->uuid('uuid');
            $table->unsignedInteger('occurrence_client_id')->nullable();
            $table->unsignedInteger('occurrence_id')->nullable();
            $table->string('telefone');
            $table->string('conteudo');
            $table->dateTime('agendamento')->nullable();
            $table->dateTime('data_envio')->nullable();
            $table->string('status')->nullable();
            $table->string('status_detalhe')->nullable();
            $table->string('status_motivo')->nullable();
            $table->timestamps();

            $table->index(["occurrence_id"], 'fk_sms_occurrences1_idx');

            $table->foreign('occurrence_id', 'fk_sms_occurrences1_idx')
                ->references('id')->on('occurrences')
                ->onDelete('restrict')
                ->onUpdate('cascade');

            $table->index(["occurrence_client_id"], 'fk_sms_occurrence_clients1_idx');

            $table->foreign('occurrence_client_id', 'fk_sms_occurrence_clients1_idx')
                ->references('id')->on('occurrence_clients')
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
		Schema::drop('sms');
	}
}
