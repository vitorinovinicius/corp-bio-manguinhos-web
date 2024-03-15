<?php

use Illuminate\Database\Seeder;

class OccurrenceTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('occurrence_types')->insert(
            [
                [
                    'uuid' => \Webpatser\Uuid\Uuid::generate(),
                    'name' => 'Padrão',
                    'description' => 'Padrão',
                    'created_at' => \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now(),

                ],
            ]

        );
    }
}