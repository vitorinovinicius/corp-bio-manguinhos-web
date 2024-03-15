<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArchivesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('archives', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('uuid');
            $table->integer('type')->comment('1 - Vehiches');
            $table->unsignedInteger('user_id');
            $table->string('url');
            $table->string('name');
            $table->string('original_name');
            $table->unsignedInteger('reference_id');

            $table->timestamps();

            $table->index(["user_id"], 'fk_archive_users1_idx');

            $table->foreign('user_id', 'fk_archive_users1_idx')
                ->references('id')->on('users')
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
        Schema::dropIfExists('archives');
    }
}
