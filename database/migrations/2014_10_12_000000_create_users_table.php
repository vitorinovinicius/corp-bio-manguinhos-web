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
            $table->string('name');
            $table->string('email');
            $table->string('password');
            $table->string('cpf')->nullable();
            $table->integer('status')->default('1');
            $table->string('token_access')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();

            $table->index(["name"], 'users_name_idx');

            $table->index(["email"], 'users_email_idx');

            $table->unique(["id"], 'id_UNIQUE');

            $table->unique(["uuid"], 'users_uuid_unique');

            $table->unique(["email"], 'users_email_unique');
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
