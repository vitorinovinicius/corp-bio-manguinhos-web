<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateOccurrenceDataClientsTable.
 */
class CreateOccurrenceDataClientsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('occurrence_data_clients', function(Blueprint $table) {
            $table->increments('id');
            $table->uuid('uuid');
            $table->unsignedInteger('occurrence_id')->unique();

            $table->integer("cliente_tipo")->nullable()->comment("1 - Outros / 2 - Próprio / 3 - Parente");
            $table->string("cliente_tipo_outros")->nullable();
            $table->string("cliente_nome")->nullable();
            $table->string("cliente_email")->nullable();
            $table->string("cliente_cpf")->nullable();
            $table->string("cliente_telefone")->nullable();
            $table->boolean("cliente_recebe_email")->nullable();
            $table->string("cliente_assinatura_tecnico")->nullable();

            $table->timestamps();

            $table->index(["occurrence_id"], 'fk_occurrence_data_clients_occurrences1_idx');

            $table->foreign('occurrence_id', 'fk_occurrence_data_clients_occurrences1_idx')
                ->references('id')->on('occurrences')
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
		Schema::drop('occurrence_data_clients');
	}
}
