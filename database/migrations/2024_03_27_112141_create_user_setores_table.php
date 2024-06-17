<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'user_setores';
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
            $table->unsignedInteger('user_id')->nullable();
            $table->unsignedInteger('setor_id')->nullable();

            $table->timestamps();
            $table->softDeletes();

			$table->index(["user_id"], 'fk_user_setores_user_idx');
			$table->index(["setor_id"], 'fk_user_setores_setor_idx');
			
            $table->foreign('user_id','fk_user_setores_user_idx')
                ->references('id')->on('users')
                ->onDelete('restrict')
                ->onUpdate('cascade');
			
            $table->foreign('setor_id','fk_user_setores_setor_idx')
                ->references('id')->on('setores')
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
