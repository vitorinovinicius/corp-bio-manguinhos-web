<?php

use Illuminate\Database\Seeder;
use Webpatser\Uuid\Uuid;

class OccurrenceTypeFormTableSeeder extends Seeder
{

    public function run()
    {
        DB::table('occurrence_type_forms')->insert(
            [
                'uuid' => \Webpatser\Uuid\Uuid::generate(),
                'occurrence_type_id' => 1,
                'form_id' => 1,
                'is_required' => 0,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ]
        );

    }

}