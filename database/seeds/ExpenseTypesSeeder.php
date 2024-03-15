<?php

use Illuminate\Database\Seeder;

class ExpenseTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('expense_types')->insert(
            [
                [
                    'uuid' => \Webpatser\Uuid\Uuid::generate(),
                    'name' => 'Alimentação',                    
                    'created_at' => \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now(),

                ],
                [
                    'uuid' => \Webpatser\Uuid\Uuid::generate(),
                    'name' => 'Combustível',                    
                    'created_at' => \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now(),

                ],
                [
                    'uuid' => \Webpatser\Uuid\Uuid::generate(),
                    'name' => 'Correio',                    
                    'created_at' => \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now(),

                ],
                [
                    'uuid' => \Webpatser\Uuid\Uuid::generate(),
                    'name' => 'Estacionamento',                    
                    'created_at' => \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now(),

                ],
                [
                    'uuid' => \Webpatser\Uuid\Uuid::generate(),
                    'name' => 'Hospedagem',                    
                    'created_at' => \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now(),

                ],
                [
                    'uuid' => \Webpatser\Uuid\Uuid::generate(),
                    'name' => 'Incentivo',                    
                    'created_at' => \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now(),

                ],
                [
                    'uuid' => \Webpatser\Uuid\Uuid::generate(),
                    'name' => 'Pedágio',                    
                    'created_at' => \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now(),

                ],
                [
                    'uuid' => \Webpatser\Uuid\Uuid::generate(),
                    'name' => 'Relacionamento',                    
                    'created_at' => \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now(),

                ],
                [
                    'uuid' => \Webpatser\Uuid\Uuid::generate(),
                    'name' => 'Transporte',                    
                    'created_at' => \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now(),

                ],
                [
                    'uuid' => \Webpatser\Uuid\Uuid::generate(),
                    'name' => 'Eventos',                    
                    'created_at' => \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now(),

                ],
                [
                    'uuid' => \Webpatser\Uuid\Uuid::generate(),
                    'name' => 'Cartão',                    
                    'created_at' => \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now(),

                ],
                [
                    'uuid' => \Webpatser\Uuid\Uuid::generate(),
                    'name' => 'Outros',                    
                    'created_at' => \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now(),

                ],
            ]
        );
    }
}
