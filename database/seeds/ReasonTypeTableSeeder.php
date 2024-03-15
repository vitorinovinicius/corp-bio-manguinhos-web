<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Webpatser\Uuid\Uuid;

class ReasonTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('reason_types')->insert([
            [
                'uuid'       => Uuid::generate()->string,
                'name'       => 'Interferências',
                'created_at' => \Carbon\Carbon::now()
            ]
        ]);
    }
}
