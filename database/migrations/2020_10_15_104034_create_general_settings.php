<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGeneralSettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('general_settings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('uuid');

            $table->string('s3_key')->nullable();
            $table->string('s3_secret')->nullable();
            $table->string('s3_region')->nullable();
            $table->string('s3_bucket')->nullable();
            $table->string('s3_path')->nullable();

            $table->string('google_maps_key')->nullable();

            $table->string('zenvia_account')->nullable();
            $table->string('zenvia_password')->nullable();
            $table->string('zenvia_from')->nullable();

            $table->string('bitly_access_token')->nullable();
            $table->string('redirect')->nullable();

            $table->string('dynamodb_key')->nullable();
            $table->string('dynamodb_secret')->nullable();
            $table->string('dynamodb_region')->nullable();
            $table->string('dynamodb_local_endpoint')->nullable();

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
        Schema::dropIfExists('general_settings');
    }
}
