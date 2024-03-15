<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOccurrencePdfs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('occurrence_pdfs', function (Blueprint $table) {

            $table->increments('id');
            $table->uuid('uuid');
            $table->integer('type')->comment('1-Pdf com imagem 2-Pdf sem imagem');
            $table->string('url');
            $table->unsignedInteger('occurrence_id');
            $table->unsignedInteger('form_id')->nullable();
            $table->unsignedInteger('contractor_id')->nullable();
            $table->timestamps();

            $table->index('occurrence_id');

            $table->foreign('occurrence_id')
            ->references('id')->on('occurrences')
            ->onDelete('restrict')
            ->onUpdate('cascade');

            $table->index('form_id');

            $table->foreign('form_id')
            ->references('id')->on('forms')
            ->onDelete('restrict')
            ->onUpdate('cascade');

            $table->index('contractor_id');
    
            $table->foreign('contractor_id')
            ->references('id')->on('contractors')
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
        Schema::dropIfExists('occurrence_pdfs');
    }
}
