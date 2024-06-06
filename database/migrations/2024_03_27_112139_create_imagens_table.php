<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
	
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'imagens';

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
			$table->string('url_imagem')->nullable()->comment('Caminho da imagem');
			$table->integer('tipo_imagem')->nullable()->comment('1 - imagem, 2 - gráfico, 3 - tabela');
			$table->integer('legenda')->nullable()->comment('Legenda da imagem');

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
		Schema::dropIfExists($this->set_schema_table);
	}
};
