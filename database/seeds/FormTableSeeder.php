<?php

use Illuminate\Database\Seeder;

use Webpatser\Uuid\Uuid;

class FormTableSeeder extends Seeder
{

    public function run()
    {
        DB::table('forms')->insert(
            [
                'uuid' => Uuid::generate(),
                'name' => 'Formulário Padrão',
                'description' => 'Formulário Padrão',
                'status' => 1,
                'version' => 1,
                'type' => 1,
                'foto' => 1,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ]
        );

    }

}

