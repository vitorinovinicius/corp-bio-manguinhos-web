<?php

use Illuminate\Database\Seeder;
use Webpatser\Uuid\Uuid;

class ContractorOccurrenceTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 1; $i++) {
            for ($j = 1; $j <= 1; $j++) {
                DB::table('contractor_occurrence_types')->insert([
                    'uuid' => Uuid::generate(),
                    'contractor_id' => $j,
                    'occurrence_type_id' => $i,
                    'capacity' => 1000,
                    'created_at' => \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now(),
                ]);
            }
        }

    }
}
