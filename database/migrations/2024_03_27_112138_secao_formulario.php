<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SecaoFormulario extends Migration
{
    
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'secao_formularios';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		if (Schema::hasTable($this->set_schema_table)) return;
		Schema::create($this->set_schema_table, function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
			$table->uuid('uuid')->unique();
			$table->unsignedInteger('formulario_id')->nullable();
			$table->unsignedInteger('secao_id')->nullable()->comment('Vincula a um titulo ou sub-titulo da seção do formulário');
            $table->unsignedInteger('setor_id')->nullable();
            $table->unsignedInteger('user_id')->nullable();
			$table->string('descricao')->nullable();
			$table->text('texto')->nullable()->comment('Conteúdo do corpo da seção do formulário');
			$table->integer('limite_caracteres')->nullable()->comment('Limite de caracteres para o usuário preencher');
			$table->integer('status')->default(0)->comment('0 - Pendente, 1 - Em andamento, 2 - analisando, 3 - Em correção, 4 - Concluído');
			$table->integer('email_status')->nullable()->comment('1 - Enviado, 2 - Confirmado');

            $table->timestamps();
            $table->softDeletes();

			$table->index(["formulario_id"], 'fk_secao_formulario_formulario_idx');
			$table->index(["user_id"], 'fk_secao_formulario_user_idx');
			$table->index(["setor_id"], 'fk_secao_formulario_setor_idx');
			$table->index(["secao_id"], 'fk_secao_formulario_secao_idx');

            $table->foreign('formulario_id','fk_secao_formulario_formulario_idx')
                ->references('id')->on('formularios')
                ->onDelete('restrict')
                ->onUpdate('cascade');

            $table->foreign('user_id','fk_secao_formulario_user_idx')
                ->references('id')->on('users')
                ->onDelete('restrict')
                ->onUpdate('cascade');

            $table->foreign('setor_id','fk_secao_formulario_setor_idx')
                ->references('id')->on('setores')
                ->onDelete('restrict')
                ->onUpdate('cascade');

            $table->foreign('secao_id','fk_secao_formulario_secao_idx')
                ->references('id')->on('secao_formularios')
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
