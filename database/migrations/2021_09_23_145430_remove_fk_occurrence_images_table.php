<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveFkOccurrenceImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('occurrence_images', function (Blueprint $table) {

            $table->dropForeign('fk_occurrence_images_form_field_idx');
            $table->dropForeign('fk_occurrence_images_form_idx');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('occurrence_images', function (Blueprint $table) {

            $table->foreign('form_id', 'fk_occurrence_images_form_idx')
                ->references('id')->on('forms')
                ->onDelete('restrict')
                ->onUpdate('cascade');

            $table->foreign('form_field_id', 'fk_occurrence_images_form_field_idx')
                ->references('id')->on('form_fields')
                ->onDelete('restrict')
                ->onUpdate('cascade');
        });
    }
}
