<?php

use Illuminate\Database\Seeder;

class ExempleOccurrenceTypeFormTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 1; $i++) {
            DB::table('occurrence_type_forms')->insert(
                [
                    'uuid' => \Webpatser\Uuid\Uuid::generate(),
                    'occurrence_type_id' => $i,
                    'form_id' => $i,
                    'is_required' => 1,
                    'created_at' => \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now(),
                ]
            );
        }
    }
}
