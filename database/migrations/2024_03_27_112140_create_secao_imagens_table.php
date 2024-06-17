<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'secao_imagens';
	
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
			$table->uuid('uuid')->unique();
            $table->unsignedInteger('secao_formulario_id')->nullable();
            $table->unsignedInteger('imagem_id')->nullable();

            $table->timestamps();
            $table->softDeletes();

			$table->index(["secao_formulario_id"], 'fk_secao_imagens_secao_formulario_idx');
			$table->index(["imagem_id"], 'fk_secao_imagens_imagem_idx');
			
            $table->foreign('secao_formulario_id','fk_secao_imagens_secao_formulario_idx')
                ->references('id')->on('secao_formularios')
                ->onDelete('restrict')
                ->onUpdate('cascade');
			
            $table->foreign('imagem_id','fk_secao_imagens_imagem_idx')
                ->references('id')->on('imagens')
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
};
