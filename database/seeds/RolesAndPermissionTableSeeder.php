<?php

use Artesaos\Defender\Facades\Defender;
use Illuminate\Database\Seeder;
use Webpatser\Uuid\Uuid;
use Carbon\Carbon;

class RolesAndPermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //CRIANDO AS ROLES

        $superUserRole = Defender::createRole("superuser");
        $adminRole = Defender::createRole("admin");
        $gestorRole = Defender::createRole("gestor");
        $colaboradorRole = Defender::createRole("colaborador");

        //CRIANDO AS PERMISSIONS

        //USERS PERMISSIONS
        Defender::createPermission('users.index', 'Listar Usuários');
        Defender::createPermission('users.show', 'Ver Usuários');
        Defender::createPermission('users.create', 'Criar Usuários');
        Defender::createPermission('users.edit', 'Editar Usuários');
        Defender::createPermission('users.destroy', 'Deletar Usuários');
        Defender::createPermission('users.change_password', 'Mudar senha de Usuários');

        //PERMISSIONS
        Defender::createPermission('permissions.index', 'Listar Permissões');
        Defender::createPermission('permissions.show', 'Ver Permissões');
        Defender::createPermission('permissions.create', 'Criar Permissões');
        Defender::createPermission('permissions.edit', 'Editar Permissões');
        Defender::createPermission('permissions.destroy', 'Deletar Permissões');

        //ROLES
        Defender::createPermission('roles.index', 'Listar roles');
        Defender::createPermission('roles.create', 'Criar roles');
        Defender::createPermission('roles.show', 'Ver roles');
        Defender::createPermission('roles.edit', 'Editar roles');
        Defender::createPermission('roles.destroy', 'Deletar roles');

        //CONFIGURATION
        Defender::createPermission('configuration.index', 'Configurações');
        Defender::createPermission('configuration.store', 'Configurações - Store');

        //General Settings
        
        Defender::createPermission('general_setting.index', 'Listar configurações gerais');
        Defender::createPermission('general_setting.show', 'Ver configurações gerais');
        Defender::createPermission('general_setting.create', 'Criar configurações gerais');
        Defender::createPermission('general_setting.edit', 'Editar configurações gerais');
        Defender::createPermission('general_setting.destroy', 'Deletar configurações gerais');

        //ADICIONANDO PERMISSONS AS ROLES

        //ROOT ROLE
        $listPermissions = Defender::permissionsList();

        foreach ($listPermissions as $key => $permission) {

            $permissionNow = Defender::findPermissionById($key);

            $superUserRole->attachPermission($permissionNow);
            $adminRole->attachPermission($permissionNow);
            $gestorRole->attachPermission($permissionNow);
            $colaboradorRole->attachPermission($permissionNow);

            $tipo = explode('.', $permission);

            //Regras para Gestor
            // if (
            //     ($tipo[0] == "admin")
            //     or ($tipo[0] == "log")
            //     or ($tipo[0] == "occurrences")
            //     or (($tipo[0] == "occurrence" && $tipo[1] == "index") || ($tipo[0] == "occurrence" && $tipo[1] == "show"))
            //     or (($tipo[0] == "users" && $tipo[1] == "index") || ($tipo[0] == "users" && $tipo[1] == "show"))
            //     or (($tipo[0] == "operator" && $tipo[1] == "index") || ($tipo[0] == "operator" && $tipo[1] == "show") || ($tipo[0] == "operator" && $tipo[1] == "edit"))
            //     or (($tipo[0] == "occurrence_clients" && $tipo[1] == "index") || ($tipo[0] == "occurrence_clients" && $tipo[1] == "show") || ($tipo[0] == "occurrence_clients" && $tipo[1] == "edit"))
            //     or (($tipo[0] == "document" && $tipo[1] == "index") || ($tipo[0] == "document" && $tipo[1] == "show"))
            //     or (($tipo[0] == "importOs" && $tipo[1] == "index") || ($tipo[0] == "importOs" && $tipo[1] == "show"))
            //     or (($tipo[0] == "log_imports" && $tipo[1] == "index") || ($tipo[0] == "log_imports" && $tipo[1] == "show"))
            //     or (($tipo[0] == "log_import_errors" && $tipo[1] == "index") || ($tipo[0] == "log_import_errors" && $tipo[1] == "show"))
            //     or (($tipo[0] == "export" && $tipo[1] == "index") || ($tipo[0] == "export" && $tipo[1] == "show"))
            //     or (($tipo[0] == "form" && $tipo[1] == "index") || ($tipo[0] == "form" && $tipo[1] == "show"))
            //     or (($tipo[0] == "occurrence_type_form" && $tipo[1] == "index") || ($tipo[0] == "occurrence_type_form" && $tipo[1] == "show"))
            //     or (($tipo[0] == "occurrence_type" && $tipo[1] == "index") || ($tipo[0] == "occurrence_type" && $tipo[1] == "show"))
            //     or (($tipo[0] == "equipment" && $tipo[1] == "index") || ($tipo[0] == "equipment" && $tipo[1] == "show"))
            // ) {
            //     $gestorRole->attachPermission($permissionNow);
            // }
        }
    }
}
