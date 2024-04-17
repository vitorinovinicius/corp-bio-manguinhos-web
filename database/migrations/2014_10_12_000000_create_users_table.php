<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'users';

    /**
     * Run the migrations.
     * @table users
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->uuid('uuid');
            $table->unsignedInteger('empresa_id')->nullable();
            $table->string('name');
            $table->string('lastname')->nullable();
            $table->string('email');
            $table->string('registry')->nullable();
            $table->string('password');
            $table->string('cpf')->nullable();
            $table->string('device')->nullable();
            $table->string('device_version')->nullable();
            $table->string('longitude')->nullable();
            $table->string('latitude')->nullable();
            $table->dateTime('last_connection')->nullable();
            $table->integer('status')->default('1');
            $table->string('address')->nullable();
            $table->integer('number')->nullable();
            $table->string('cep')->nullable();
            $table->string('district')->nullable();
            $table->string('city')->nullable();
            $table->string('uf')->nullable();
            $table->string('complement')->nullable();
            $table->dateTime('expiration')->nullable();
            $table->dateTime('last_login')->nullable();
            $table->string('ip')->nullable();
            $table->integer('mobile_number')->nullable();
            $table->string('platform_mobile')->nullable();
            $table->string('model')->nullable();
            $table->date('valid')->nullable();
            $table->string('certificate')->nullable();
            $table->string("analisador")->nullable();
            $table->string("manometro")->nullable();
            $table->string("cronometro")->nullable();
            $table->string("trena")->nullable();
            $table->string("detector_de_gas")->nullable();
            $table->string("paquimetro")->nullable();
            $table->string("assinatura")->nullable();
            $table->string("foto")->nullable();
            $table->string("ecc")->nullable();
            $table->string('token_access')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();

            $table->index(["name"], 'users_name_idx');

            $table->index(["email"], 'users_email_idx');

            $table->index(["empresa_id"], 'fk_users_contractors1_idx');

            $table->unique(["id"], 'id_UNIQUE');

            $table->unique(["uuid"], 'users_uuid_unique');

            $table->unique(["email"], 'users_email_unique');


            $table->foreign('empresa_id', 'fk_users_contractors1_idx')
                ->references('id')->on('empresas')
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
