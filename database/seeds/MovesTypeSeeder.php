<?php

use Illuminate\Database\Seeder;

class MovesTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $list =
            [
            "Início da Jornada de Trabalho",
            "Início do Almoço",
            "Fim do Almoço",
            "Saída para atendimento",
            "Chegada no local do atendimento",
            "Iniciar Atendimento",
            "Fechar Atendimento",
            "Fim da Jornada de Trabalho",
            ];

        foreach($list as $item) {
            DB::table('move_types')->insert([
                [
                    'uuid' => \Webpatser\Uuid\Uuid::generate(),
                    'name' => $item,
                    'created_at' => \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now()
                ],
            ]);
        }
    }
}
