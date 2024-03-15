<?php

use Illuminate\Database\Seeder;
use Artesaos\Defender\Facades\Defender;

class GroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //GROUP
        Defender::createPermission('groups.index', 'Listar grupos');
        Defender::createPermission('groups.show', 'Ver grupo');
        Defender::createPermission('groups.create', 'Criar grupo');
        Defender::createPermission('groups.edit', 'Editar grupo');
        Defender::createPermission('groups.destroy', 'Deletar grupo');
    }
}
