<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOccurrenceImagesTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'occurrence_images';

    /**
     * Run the migrations.
     * @table occurrence_images
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
            $table->uuid('uuid_external')->nullable();
            $table->unsignedInteger('occurrence_id');
            $table->string('url');
            $table->binary('image')->nullable();
            $table->string('reference')->nullable();
            $table->unsignedInteger('form_id')->nullable();
            $table->unsignedInteger('form_field_id')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->index(["occurrence_id"], 'fk_occurrence_images_occurrence_idx');

            $table->index(["form_id"], 'fk_occurrence_images_form_idx');

            $table->index(["form_field_id"], 'fk_occurrence_images_form_field_idx');

            $table->unique(["id"], 'id_UNIQUE');


            $table->foreign('occurrence_id', 'fk_occurrence_images_occurrence_idx')
                ->references('id')->on('occurrences')
                ->onDelete('restrict')
                ->onUpdate('cascade');

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
