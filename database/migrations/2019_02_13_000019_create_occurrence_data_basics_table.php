<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOccurrenceDataBasicsTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'occurrence_data_basics';

    /**
     * Run the migrations.
     * @table occurrence_data_basics
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('occurrence_id')->unique();
            $table->uuid('uuid');
            $table->date("data_agendamento")->nullable();
            $table->string("em_branco")->nullable();
            $table->string("organizacao")->nullable();
            $table->string("numero_os")->nullable();
            $table->string("vip")->nullable();
            $table->string("nome_os")->nullable();
            $table->string("numero_cliente")->nullable();
            $table->string("nome_cliente")->nullable();
            $table->text("situacao_os")->nullable();
            $table->string("telefone1")->nullable();
            $table->string("telefone2")->nullable();
            $table->string("telefone3")->nullable();
            $table->string("endereco")->nullable();
            $table->string("bairro")->nullable();
            $table->string("municipio")->nullable();
            $table->string("mercado")->nullable();
            $table->string("prioridade")->nullable();
            $table->string("n_os_garantia")->nullable();
            $table->text("obs_ceg")->nullable();
            $table->string("empreiteira")->nullable();
            $table->string("cups")->nullable();
            $table->string("codigo_solicitacao_zeus")->nullable();
            $table->string("solicitacao_zeus")->nullable();
            $table->string("telefone_zeus")->nullable();
            $table->string("os_alias_name")->nullable();
            $table->string("ot_alias_name")->nullable();
            $table->string("tipo_agendamento")->nullable();
            $table->string("area_origem")->nullable();
            $table->string("area_responsavel")->nullable();
            $table->dateTime("data_solicitacao")->nullable();
            $table->string("zona")->nullable();
            $table->string("subzona")->nullable();
            $table->string("valor_a_cobrar")->nullable();
            $table->text("obs_empreiteira")->nullable();


            $table->timestamps();
            $table->softDeletes();

            $table->index(["occurrence_id"], 'fk_occurrence_data_basics_occurrences1_idx');

            $table->unique(["id"], 'id_UNIQUE');

            $table->foreign('occurrence_id', 'fk_occurrence_data_basics_occurrences1_idx')
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
       Schema::dropIfExists($this->set_schema_table);
     }
}
