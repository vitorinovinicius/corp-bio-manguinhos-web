<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateRelatoriosTable.
 */
class CreateRelatoriosTable extends Migration
{
	
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'relatorios';

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
            $table->string('url_documento')->nullable();
            $table->string('descricao');
            $table->integer('status')->default(0)->comment(
				'
					0 - Iniciado,
					1 - Em andamento,
					2 - Em analise,
					3 - Concluído
				'
			);

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
}
