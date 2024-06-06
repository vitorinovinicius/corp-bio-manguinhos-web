<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
	
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'formularios';

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
			$table->unsignedInteger('relatorio_id')->nullable();
			$table->string('descricao')->nullable();
            $table->integer('status')->default(0)->comment(
				'
					0 - Pendente,
					1 - Em andamento,
					2 - analisando,
					3 - Em correção,
					4 - Concluído
				'
			);

            $table->timestamps();
            $table->softDeletes();

			$table->index(["relatorio_id"], 'fk_formulario_relatorio_idx');

            $table->foreign('relatorio_id','fk_formulario_relatorio_idx')
                ->references('id')->on('relatorios')
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

