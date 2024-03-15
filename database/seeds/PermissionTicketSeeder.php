<?php

use Artesaos\Defender\Facades\Defender;
use Illuminate\Database\Seeder;

class PermissionTicketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Defender::createPermission('ticket.index', 'Listar tickets');
        Defender::createPermission('ticket.show', 'Ver ticket');
        Defender::createPermission('ticket.create', 'Criar ticket');
        Defender::createPermission('ticket.edit', 'Editar ticket');
        Defender::createPermission('ticket.destroy', 'Deletar ticket');
    }
}
