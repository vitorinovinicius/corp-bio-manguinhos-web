<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Webpatser\Uuid\Uuid;

class ReasonTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // MOTIVOS DAS INTERFERENCIAS

        DB::table('reasons')->insert([
            [
                'uuid'       => Uuid::generate()->string,
                'description' => 'Aguardando supervisão / fiscalização CLIENTE',
                'type_id'    => 1,
                'status'     => 0,
                'created_at' => \Carbon\Carbon::now()
            ]
        ]);

        DB::table('reasons')->insert([
            [
                'uuid'       => Uuid::generate()->string,
                'description' => 'Dano à instalação',
                'type_id'    => 1,
                'status'     => 0,
                'created_at' => \Carbon\Carbon::now()
            ]
        ]);

        DB::table('reasons')->insert([
            [
                'uuid'       => Uuid::generate()->string,
                'description' => 'Deslocamento',
                'type_id'    => 1,
                'status'     => 0,
                'created_at' => \Carbon\Carbon::now()
            ]
        ]);

        DB::table('reasons')->insert([
            [
                'uuid'       => Uuid::generate()->string,
                'description' => 'Dificuldade / Improdutividade',
                'type_id'    => 1,
                'status'     => 0,
                'created_at' => \Carbon\Carbon::now()
            ]
        ]);

        DB::table('reasons')->insert([
            [
                'uuid'       => Uuid::generate()->string,
                'description' => 'Falta de equipamento',
                'type_id'    => 1,
                'status'     => 0,
                'created_at' => \Carbon\Carbon::now()
            ]
        ]);

        DB::table('reasons')->insert([
            [
                'uuid'       => Uuid::generate()->string,
                'description' => 'Falta de licença',
                'type_id'    => 1,
                'status'     => 0,
                'created_at' => \Carbon\Carbon::now()
            ]
        ]);

        DB::table('reasons')->insert([
            [
                'uuid'       => Uuid::generate()->string,
                'description' => 'Falta de mão de obra',
                'type_id'    => 1,
                'status'     => 0,
                'created_at' => \Carbon\Carbon::now()
            ]
        ]);

        DB::table('reasons')->insert([
            [
                'uuid'       => Uuid::generate()->string,
                'description' => 'Falta de material CJATO',
                'type_id'    => 1,
                'status'     => 0,
                'created_at' => \Carbon\Carbon::now()
            ]
        ]);

        DB::table('reasons')->insert([
            [
                'uuid'       => Uuid::generate()->string,
                'description' => 'Falta de material CLIENTE',
                'type_id'    => 1,
                'status'     => 0,
                'created_at' => \Carbon\Carbon::now()
            ]
        ]);

        DB::table('reasons')->insert([
            [
                'uuid'       => Uuid::generate()->string,
                'description' => 'Falta de micro programação',
                'type_id'    => 1,
                'status'     => 0,
                'created_at' => \Carbon\Carbon::now()
            ]
        ]);

        DB::table('reasons')->insert([
            [
                'uuid'       => Uuid::generate()->string,
                'description' => 'Falta de projeto',
                'type_id'    => 1,
                'status'     => 0,
                'created_at' => \Carbon\Carbon::now()
            ]
        ]);

        DB::table('reasons')->insert([
            [
                'uuid'       => Uuid::generate()->string,
                'description' => 'Falta de transporte',
                'type_id'    => 1,
                'status'     => 0,
                'created_at' => \Carbon\Carbon::now()
            ]
        ]);

        DB::table('reasons')->insert([
            [
                'uuid'       => Uuid::generate()->string,
                'description' => 'Tempo chuvoso',
                'type_id'    => 1,
                'status'     => 0,
                'created_at' => \Carbon\Carbon::now()
            ]
        ]);

        DB::table('reasons')->insert([
            [
                'uuid'       => Uuid::generate()->string,
                'description' => 'Treinamento / Reunião',
                'type_id'    => 1,
                'status'     => 0,
                'created_at' => \Carbon\Carbon::now()
            ]
        ]);

    }
}
