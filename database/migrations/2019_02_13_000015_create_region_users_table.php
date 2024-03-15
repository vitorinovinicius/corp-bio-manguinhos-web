<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRegionUsersTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'region_users';

    /**
     * Run the migrations.
     * @table region_users
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('region_id');
            $table->unsignedInteger('user_id');

            $table->timestamps();
            $table->softDeletes();

            $table->index(["region_id"], 'fk_region_users_regions1_idx');

            $table->index(["user_id"], 'fk_region_users_users1_idx');

            $table->unique(["id"], 'id_UNIQUE');


            $table->foreign('region_id', 'fk_region_users_regions1_idx')
                ->references('id')->on('regions')
                ->onDelete('restrict')
                ->onUpdate('cascade');

            $table->foreign('user_id', 'fk_region_users_users1_idx')
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
       Schema::dropIfExists($this->set_schema_table);
     }
}
