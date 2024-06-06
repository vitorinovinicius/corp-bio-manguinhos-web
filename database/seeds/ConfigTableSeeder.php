<?php

use Illuminate\Database\Seeder;
use Webpatser\Uuid\Uuid;
use Carbon\Carbon;

class ConfigTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('configurations')->insert([
            [
                'uuid' => Uuid::generate(),
                'config_key' => 'general.equipment.discount.equipament',
                'config_value' => '15',
                'tipo' => 2,
                'tipo_form' => 2,
//                'contractor_id' => 2,
                'description' => 'Desconto máximo para Equipamento',
            ], [
                'uuid' => Uuid::generate(),
                'config_key' => 'general.equipment.discount.stove',
                'config_value' => '18',
                'tipo' => 2,
                'tipo_form' => 2,
//                'contractor_id' => 2,
                'description' => 'Desconto máximo para Fogão',
            ],
        ]);

        DB::table('configurations')->insert([
            [
                'uuid' => Uuid::generate(),
                'config_key' => 'certificado.bloqueio_auto',
                'config_value' => '1',
                'tipo' => 1,
                'tipo_form' => 1,
                'tipo_user' => 1,
                'contractor_id' => 1,
                'description' => 'Bloqueio automático após vencimento do certificado.',
            ], [
                'uuid' => Uuid::generate(),
                'config_key' => 'email.new_client',
                'config_value' => '',
                'tipo' => 1,
                'tipo_form' => 2,
                'tipo_user' => 1,
                'contractor_id' => 1,
                'description' => 'Email para envio novos clientes.',
            ],[
                'uuid' => Uuid::generate(),
                'config_key' => 'clear.day_os_mobile',
                'config_value' => '',
                'tipo' => 1,
                'tipo_form' => 2,
                'tipo_user' => 1,
                'contractor_id' => 1,
                'description' => 'Limpar os da tela do mobile, quantidade de dias. Padrão D - 2.',
            ],[
                'uuid' => Uuid::generate(),
                'config_key' => 'order.occurrences',
                'config_value' => 'CLIENT',
                'tipo' => 1,
                'tipo_form' => 2,
                'tipo_user' => null,
                'contractor_id' => 1,
                'description' => 'Ordenar baixa de OS CLIENT, ENDERECO.',
            ]
        ]);

    }
}
