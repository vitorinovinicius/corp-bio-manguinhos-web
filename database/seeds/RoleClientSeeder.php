<?php

use Illuminate\Database\Seeder;
use Artesaos\Defender\Facades\Defender;

class RoleClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $clientRole = Defender::createRole("cliente");

        Defender::createPermission('client.index', 'Dashboard de Clientes');
    }
}
