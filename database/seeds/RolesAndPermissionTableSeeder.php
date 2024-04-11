<?php

use Artesaos\Defender\Facades\Defender;
use Illuminate\Database\Seeder;

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
        $supervisorRole = Defender::createRole("supervisor");
        $operatorRole = Defender::createRole("operator");
        $atendenteRole = Defender::createRole("atendente");
        $gestorRole = Defender::createRole("gestor");
        $regiaoRole = Defender::createRole("regiao");
        $financeiroRole = Defender::createRole("financeiro");

        //CRIANDO AS PERMISSIONS

        //APP_VERSION PERMISSIONS
        Defender::createPermission('app_version.index', 'Listar Versão do Aplicativo');
        Defender::createPermission('app_version.show', 'Ver Versão do Aplicativo');
        Defender::createPermission('app_version.create', 'Criar Versão do Aplicativo');
        Defender::createPermission('app_version.edit', 'Editar Versão do Aplicativo');
        Defender::createPermission('app_version.destroy', 'Deletar Versão do Aplicativo');

        //STATUS CANCELAMENTO PERMISSIONS
        Defender::createPermission('cancelamento_status.index', 'Listar Status do cancelamento');
        Defender::createPermission('cancelamento_status.show', 'Ver Status do cancelamento');
        Defender::createPermission('cancelamento_status.create', 'Criar Status do cancelamento');
        Defender::createPermission('cancelamento_status.edit', 'Editar Status do cancelamento');
        Defender::createPermission('cancelamento_status.destroy', 'Deletar Status do cancelamento');

        //USERS PERMISSIONS
        Defender::createPermission('users.index', 'Listar Usuários');
        Defender::createPermission('users.show', 'Ver Usuários');
        Defender::createPermission('users.create', 'Criar Usuários');
        Defender::createPermission('users.edit', 'Editar Usuários');
        Defender::createPermission('users.destroy', 'Deletar Usuários');
        Defender::createPermission('users.change_password', 'Mudar senha de Usuários');

        //TEAMS PERMISSIONS
        Defender::createPermission('team.index', 'Listar Equipes');
        Defender::createPermission('team.show', 'Ver Equipes');
        Defender::createPermission('team.create', 'Criar Equipes');
        Defender::createPermission('team.edit', 'Editar Equipes');
        Defender::createPermission('team.destroy', 'Deletar Equipes');

        //INTERFERENCES PERMISSIONS
        Defender::createPermission('interference.index', 'Listar Interferências');
        Defender::createPermission('interference.show', 'Ver Interferências');
        Defender::createPermission('interference.create', 'Criar Interferências');
        Defender::createPermission('interference.edit', 'Editar Interferências');
        Defender::createPermission('interference.destroy', 'Deletar Interferências');
        Defender::createPermission('interference.relatorio', 'Relatório Interferências');

        //OPERATORS PERMISSIONS
        Defender::createPermission('operator.index', 'Listar Operadores');
        Defender::createPermission('operator.show', 'Ver Operadores');
        Defender::createPermission('operator.create', 'Criar Operadores');
        Defender::createPermission('operator.edit', 'Editar Operadores');
        Defender::createPermission('operator.destroy', 'Deletar Operadores');

        //OCCURRENCES PERMISSIONS
        Defender::createPermission('occurrence.index', 'Listar Occorrências');
        Defender::createPermission('occurrence.show', 'Ver Occorrências');
        Defender::createPermission('occurrence.create', 'Criar Occorrências');
        Defender::createPermission('occurrence.edit', 'Editar Occorrências');
        Defender::createPermission('occurrence.destroy', 'Deletar Occorrências');

        //OCCURRENCES DERIVADOS
        Defender::createPermission('occurrences.pending', 'Listar Occorrências Pendentes');
        Defender::createPermission('occurrences.unassigned', 'Listar Ocorrências não atribuídas');
        Defender::createPermission('occurrences.closed', 'Listar Ocorrências  Realizadas');
        Defender::createPermission('occurrences.closed_unsolved', 'Listar Ocorrências Não  Realizadas');
        Defender::createPermission('occurrences.associate.store', 'Associar única ocorrencia e/ou reagenda');
        Defender::createPermission('occurrences.associate.operator', 'Associa vários ocorrências a um operador');
        Defender::createPermission('occurrences.export', 'Exporta OS');
        Defender::createPermission('occurrences.to_approved', 'Listar Occorrências pendentes de aprovação do financeiro');
        Defender::createPermission('occurrences.delete_anexos', 'Permite exclusão dos arquivos anexados a uma OS');
        Defender::createPermission('occurrences.order', 'Permite Ordenação das OSs');
	    Defender::createPermission('occurrence.create_subos', 'Criar Sub OS');

        //OCCURRENCES TYPE PERMISSIONS
        Defender::createPermission('occurrence_type.index', 'Listar Tipo de Ocorrência');
        Defender::createPermission('occurrence_type.show', 'Ver Tipo de Ocorrência');
        Defender::createPermission('occurrence_type.create', 'Criar Tipo de Ocorrência');
        Defender::createPermission('occurrence_type.edit', 'Editar Tipo de Ocorrência');
        Defender::createPermission('occurrence_type.destroy', 'Deletar Tipo de Ocorrência');
        Defender::createPermission('occurrence_type.closeOS', 'Fecha Tipo de Ocorrência');

        //OCCURRENCES ARCHIVE 
        Defender::createPermission('occurrence_archive.destroy', 'Exluir Anexo occurrence');




        //OCCURRENCES PERMISSIONS
        Defender::createPermission('contractor.index', 'Listar Empreiteiras');
        Defender::createPermission('contractor.show', 'Ver Empreiteiras');
        Defender::createPermission('contractor.create', 'Criar Empreiteiras');
        Defender::createPermission('contractor.edit', 'Editar Empreiteiras');
        Defender::createPermission('contractor.destroy', 'Deletar Empreiteiras');
        Defender::createPermission('contractor.closeOS', 'Fecha Empreiteiras');

        //MOVE TYPES
        Defender::createPermission('move-type.index', 'Listar Tipo de Movimentação');
        Defender::createPermission('move-type.show', 'Ver Tipo de Movimentação');
        Defender::createPermission('move-type.create', 'Criar Tipo de Movimentação');
        Defender::createPermission('move-type.edit', 'Editar Tipo de Movimentação');
        Defender::createPermission('move-type.destroy', 'Deletar Tipo de Movimentação');

        //CLIENTS PERMISSIONS
        Defender::createPermission('occurrence_clients.index', 'Listar Clientes');
        Defender::createPermission('occurrence_clients.show', 'Ver Clientes');
        Defender::createPermission('occurrence_clients.create', 'Criar Clientes');
        Defender::createPermission('occurrence_clients.edit', 'Editar Clientes');
        Defender::createPermission('occurrence_clients.destroy', 'Deletar Clientes');

        //IMPORT PERMISSIONS
        Defender::createPermission('importOs.index', 'Tela de Importação');
        Defender::createPermission('importOs.import_nts', 'Tela de Importação NTS');
        Defender::createPermission('log_imports.log', 'Tela de exibição do que do log');

        //LOG IMPORT PERMISSIONS
        Defender::createPermission('log_imports.index', 'Listar Logs');
        Defender::createPermission('log_imports.show', 'Ver Logs');
        Defender::createPermission('log_imports.create', 'Criar Logs');
        Defender::createPermission('log_imports.edit', 'Editar Logs');
        Defender::createPermission('log_imports.destroy', 'Deletar Logs');

        //LOG IMPORTAÇÃO - ERROR -  PERMISSIONS
        Defender::createPermission('log_import_errors.index', 'Listar Logs de erros ');
        Defender::createPermission('log_import_errors.show', 'Ver Logs de erros');
        Defender::createPermission('log_import_errors.create', 'Criar Logs de erros');
        Defender::createPermission('log_import_errors.edit', 'Editar Logs de erros');
        Defender::createPermission('log_import_errors.destroy', 'Deletar Logs de erros');

        //PERMISSIONS
        Defender::createPermission('permissions.index', 'Listar Permissões');
        Defender::createPermission('permissions.show', 'Ver Permissões');
        Defender::createPermission('permissions.create', 'Criar Permissões');
        Defender::createPermission('permissions.edit', 'Editar Permissões');
        Defender::createPermission('permissions.destroy', 'Deletar Permissões');

        //PERMISSIONS
        Defender::createPermission('roles.index', 'Listar roles');
        Defender::createPermission('roles.create', 'Criar roles');
        Defender::createPermission('roles.show', 'Ver roles');
        Defender::createPermission('roles.edit', 'Editar roles');
        Defender::createPermission('roles.destroy', 'Deletar roles');

        //EXPORTAÇÃO
        Defender::createPermission('export.index', 'Tela inicial de exportação de arquivos');
        Defender::createPermission('export.financeiro_cs', 'Tela de exportação de OSs para Bio-Manguinhos');

        //LOG
        Defender::createPermission('log.index', 'Lista os logs de acesso ao sistema');
        Defender::createPermission('log.show', 'Exibe o log de acesso ao sistema');

        //MONITORAMENTO/DASHBOARD
        Defender::createPermission('admin.index', 'Monitoramento');
        Defender::createPermission('admin.monitoring', 'Ver Monitoramento');
        Defender::createPermission('admin.monitoring_nts', 'Ver Monitoramento NTS');
        Defender::createPermission('admin.dashboard', 'Ver Dashboard');
        Defender::createPermission('admin.technical', 'Dashboard de técnicos');

        //GRUPO DE USUÁRIOS
        Defender::createPermission('group_user.index', 'Listar Grupo de usuários');

        //CONFIGURATION
        Defender::createPermission('configuration.index', 'Configurações');
        Defender::createPermission('configuration.store', 'Configurações - Store');

        //Form
        Defender::createPermission('form.index', 'Listar Formulários');
        Defender::createPermission('form.show', 'Ver Formulários');
        Defender::createPermission('form.create', 'Criar Formulários');
        Defender::createPermission('form.edit', 'Editar Formulários');
        Defender::createPermission('form.destroy', 'Deletar Formulários');


        //FormSection
        Defender::createPermission('form_section.index', 'Listar Sessões do formulário');
        Defender::createPermission('form_section.show', 'Ver Sessões do formulário');
        Defender::createPermission('form_section.create', 'Criar Sessões do formulário');
        Defender::createPermission('form_section.edit', 'Editar Sessões do formulário');
        Defender::createPermission('form_section.destroy', 'Deletar Sessões do formulário');


        //form_field
        Defender::createPermission('form_field.index', 'Listar Campos da sessão');
        Defender::createPermission('form_field.show', 'Ver Campos da sessão');
        Defender::createPermission('form_field.create', 'Criar Campos da sessão');
        Defender::createPermission('form_field.edit', 'Editar Campos da sessão');
        Defender::createPermission('form_field.destroy', 'Deletar Campos da sessão');

        //FormGroup
        Defender::createPermission('form_group.index', 'Listar Grupos de formulário');
        Defender::createPermission('form_group.show', 'Ver Grupos de formulário');
        Defender::createPermission('form_group.create', 'Criar Grupos de formulário');
        Defender::createPermission('form_group.edit', 'Editar Grupos de formulário');
        Defender::createPermission('form_group.destroy', 'Deletar Grupos de formulário');
        Defender::createPermission('form_group.edit_user', 'Editar User Grupos de formulário');
        Defender::createPermission('form_group.create_user', 'Criar User Grupos de formulário');

        //occurrence_type_form
        Defender::createPermission('occurrence_type_form.index', 'Listar Associação de formulários');
        Defender::createPermission('occurrence_type_form.show', 'Ver Associação de formulários');
        Defender::createPermission('occurrence_type_form.create', 'Criar Associação de formulários');
        Defender::createPermission('occurrence_type_form.edit', 'Editar Associação de formulários');
        Defender::createPermission('occurrence_type_form.destroy', 'Deletar Associação de formulários');

        //documents
        Defender::createPermission('document.index', 'Listar Ordem de Trabalho');
        Defender::createPermission('document.show', 'Ver Ordem de Trabalho');
        Defender::createPermission('document.create', 'Criar Ordem de Trabalho');
        Defender::createPermission('document.edit', 'Editar Ordem de Trabalho');
        Defender::createPermission('document.destroy', 'Deletar Ordem de Trabalho');

        //Financial
        Defender::createPermission('financial.dashboard', 'Dashboard financeiro');
        Defender::createPermission('financial.index', 'Listar orçamento');
        Defender::createPermission('financial.show', 'Ver orçamento');
        Defender::createPermission('financial.create', 'Criar orçamento');
        Defender::createPermission('financial.edit', 'Editar orçamento');
        Defender::createPermission('financial.destroy', 'Deletar orçamento');

        //Financial
        Defender::createPermission('financial_communication.index', 'Listar comunicação financeira');
        Defender::createPermission('financial_communication.show', 'Ver comunicação financeira');
        Defender::createPermission('financial_communication.create', 'Criar comunicação financeira');
        Defender::createPermission('financial_communication.edit', 'Editar comunicação financeira');
        Defender::createPermission('financial_communication.destroy', 'Deletar comunicação financeira');

        //OCCURRENCES - Financial - Outros
        Defender::createPermission('occurrences.to_adjust', 'Financeiro - Para ajustar');
        Defender::createPermission('occurrences.approved', 'Listar Occorrências aprovadas pelo financeiro');
        Defender::createPermission('occurrences.adjusted', 'Lista as OSs que foram ajustadas pela ECC');
        Defender::createPermission('occurrences.disapproved', 'Lista as OSs que foram Rejeitadas pelo financeiro');
        //reports
        Defender::createPermission('report.index', 'Relatórios');
        Defender::createPermission('report.financial.executions', 'Relatório de execução');
        Defender::createPermission('report.financial.executions.show', 'Relatório de execução - Exibição');
        Defender::createPermission('report.financial.general', 'Relatório Financeiro Gerail');

        //Veículos
        Defender::createPermission('vehicles.index', 'Listar veículos');
        Defender::createPermission('vehicles.show', 'Ver veículo');
        Defender::createPermission('vehicles.create', 'Criar veículo');
        Defender::createPermission('vehicles.edit', 'Editar veículo');
        Defender::createPermission('vehicles.destroy', 'Deletar veículo');

        Defender::createPermission('vehicles.checklist', 'Checklist');

        //district
        Defender::createPermission('district.index', 'Listar Bairros');
        Defender::createPermission('district.show', 'Ver Bairros');
        Defender::createPermission('district.create', 'Criar Bairros');
        Defender::createPermission('district.edit', 'Editar Bairros');
        Defender::createPermission('district.destroy', 'Deletar Bairros');

        //contractor_district
        Defender::createPermission('contractor_district.index', 'Listar Empresa - Bairros');
        Defender::createPermission('contractor_district.show', 'Ver Empresa - Bairros');
        Defender::createPermission('contractor_district.create', 'Criar Empresa - Bairros');
        Defender::createPermission('contractor_district.edit', 'Editar Empresa - Bairros');
        Defender::createPermission('contractor_district.destroy', 'Deletar Empresa - Bairros');

        //contractor_district
        Defender::createPermission('contractor_occurrence_type.index', 'Listar Empresa - OS');
        Defender::createPermission('contractor_occurrence_type.show', 'Ver Empresa - OS');
        Defender::createPermission('contractor_occurrence_type.create', 'Criar Empresa - OS');
        Defender::createPermission('contractor_occurrence_type.edit', 'Editar Empresa - OS');
        Defender::createPermission('contractor_occurrence_type.destroy', 'Deletar Empresa - OS');

        //ALERTS
        Defender::createPermission('alerts.index', 'Listar alertas');
        Defender::createPermission('alerts.show_packages', 'Listar alertas dos volumes');
        Defender::createPermission('alerts.show_routes', 'Listar alertas das rotas');
        Defender::createPermission('alerts.show_document', 'Exibir alertas de documentos');
        Defender::createPermission('alerts.documents_close', 'Fechar alertas de documentos');

        Defender::createPermission('admin.monitoring_gastos_materiais', 'Ver Gastos de Materiais');

        //skill
        Defender::createPermission('skill.index', 'Listar Habilidades');
        Defender::createPermission('skill.show', 'Ver Habilidades');
        Defender::createPermission('skill.create', 'Criar Habilidades');
        Defender::createPermission('skill.edit', 'Editar Habilidades');
        Defender::createPermission('skill.destroy', 'Deletar Habilidades');

        //Equipment
        Defender::createPermission('equipment.index', 'Listar Equipamento');
        Defender::createPermission('equipment.show', 'Ver Equipamento');
        Defender::createPermission('equipment.create', 'Criar Equipamento');
        Defender::createPermission('equipment.edit', 'Editar Equipamento');
        Defender::createPermission('equipment.destroy', 'Deletar Equipamento');

        //General Settings
        
        Defender::createPermission('general_setting.index', 'Listar configurações gerais');
        Defender::createPermission('general_setting.show', 'Ver configurações gerais');
        Defender::createPermission('general_setting.create', 'Criar configurações gerais');
        Defender::createPermission('general_setting.edit', 'Editar configurações gerais');
        Defender::createPermission('general_setting.destroy', 'Deletar configurações gerais');

        Defender::createPermission('calendar.index', 'Calendário index');

	    Defender::createPermission('log_android.index', 'LogAndroid');

        Defender::createPermission('occurrence_image.destroy', 'Remove imagem');

        Defender::createPermission("product_category.index", 'Lista Produtos e categorias');
        Defender::createPermission("product_category.show", 'Ver Produtos e categorias');
        Defender::createPermission("product_category.create", 'Criar Produtos e categorias');
        Defender::createPermission("product_category.edit", 'Editar Produtos e categorias');
        Defender::createPermission("product_category.destroy", 'Deletar Produtos e categorias');

        Defender::createPermission('routing.index', 'Roteirização index');

        //Tipo de despesa
        Defender::createPermission("expense_type.index", 'Lista Tipo de despesas');
        Defender::createPermission("expense_type.show", 'Ver Tipo de despesas');
        Defender::createPermission("expense_type.create", 'Criar Tipo de despesas');
        Defender::createPermission("expense_type.edit", 'Editar Tipo de despesas');
        Defender::createPermission("expense_type.destroy", 'Deletar Tipo de despesas');

        //Reembolso
        Defender::createPermission("repayment.index", 'Lista Reembolsos');
        Defender::createPermission("repayment.show", 'Ver Reembolsos');
        Defender::createPermission("repayment.create", 'Criar Reembolsos');
        Defender::createPermission("repayment.edit", 'Editar Reembolsos');
        Defender::createPermission("repayment.destroy", 'Deletar Reembolsos');

        //Despesas
        Defender::createPermission("expense.index", 'Lista Despesas');
        Defender::createPermission("expense.show", 'Ver Despesas');
        Defender::createPermission("expense.create", 'Criar Despesas');
        Defender::createPermission("expense.edit", 'Editar Despesas');
        Defender::createPermission("expense.destroy", 'Deletar Despesas');

        Defender::createPermission("expense.status", 'Despesas Status');

        //OSs Recorrentes
        Defender::createPermission('plan_occurrences.index', 'Listar configurações de OS recorrentes');
        Defender::createPermission('plan_occurrences.show', 'Ver configurações de OS recorrentes');
        Defender::createPermission('plan_occurrences.create', 'Criar configurações de OS recorrentes');
        Defender::createPermission('plan_occurrences.edit', 'Editar configurações de OS recorrentes');
        Defender::createPermission('plan_occurrences.destroy', 'Deletar configurações de OS recorrentes');

        Defender::createPermission("operator.tracking", 'Rastreamento do técnico');

        //Tipo de despesa
        Defender::createPermission("workday.index", 'Lista dia de trabalho');
        Defender::createPermission("workday.show", 'Ver dia de trabalho');
        Defender::createPermission("workday.edit", 'Editar dia de trabalho');
        Defender::createPermission("workday.create", 'Criar dia de trabalho');
        Defender::createPermission("workday.destroy", 'Deletar dia de trabalho');

        //Tipo de despesa
        Defender::createPermission("workday_program.index", 'Lista programação de trabalho');
        Defender::createPermission("workday_program.show", 'Ver programação de trabalho');
        Defender::createPermission("workday_program.create", 'Criar programação de trabalho');
        Defender::createPermission("workday_program.edit", 'Editar programação de trabalho');
        Defender::createPermission("workday_program.destroy", 'Deletar programação de trabalho');

        //Zonas
        Defender::createPermission('zone.index', 'Listar Zonas');
        Defender::createPermission('zone.show', 'Ver Zona');
        Defender::createPermission('zone.create', 'Criar Zona');
        Defender::createPermission('zone.edit', 'Editar Zona');
        Defender::createPermission('zone.destroy', 'Deletar Zona');


        //ADICIONANDO PERMISSONS AS ROLES

        //ROOT ROLE
        $listPermissions = Defender::permissionsList();

        foreach ($listPermissions as $key => $permission) {

            $permissionNow = Defender::findPermissionById($key);

            $superUserRole->attachPermission($permissionNow);
//            $adminRole->attachPermission($permissionNow);

            $tipo = explode('.', $permission);

            //Regras para Região
            if (
                $tipo[0] == "occurrences"
                or ($tipo[0] == "admin")
                or ($tipo[0] == "users")
                or ($tipo[0] == "document")
                or ($tipo[0] == "report")
                or ($tipo[0] == "alerts")
                or ($tipo[0] == "interference")
                or ($tipo[0] == "skill")
                or ($tipo[0] == "log")
                or ($tipo[0] == "calendar")
                or ($tipo[0] == "occurrence_image")
                or ($tipo[0] == "routing")
                or ($tipo[0] == "expense_type")
                or ($tipo[0] == "repayment")
                or ($tipo[0] == "expense")
                or ($tipo[0] == "plan_occurrences")
                or (($tipo[0] == "contractor_district" && $tipo[1] == "contractor_district") || ($tipo[0] == "contractor_district" && $tipo[1] == "show") || ($tipo[0] == "contractor_district" && $tipo[1] == "edit") || ($tipo[0] == "contractor_district" && $tipo[1] == "create"))
                or (($tipo[0] == "contractor_occurrence_type" && $tipo[1] == "index") || ($tipo[0] == "contractor_occurrence_type" && $tipo[1] == "show") || ($tipo[0] == "contractor_occurrence_type" && $tipo[1] == "edit") || ($tipo[0] == "contractor_occurrence_type" && $tipo[1] == "create"))
                or (($tipo[0] == "operator" && $tipo[1] == "index") || ($tipo[0] == "operator" && $tipo[1] == "show"))
                or (($tipo[0] == "occurrence" && $tipo[1] == "index") || ($tipo[0] == "occurrence" && $tipo[1] == "show"))
                or (($tipo[0] == "team" && $tipo[1] == "index") || ($tipo[0] == "team" && $tipo[1] == "show"))
                or (($tipo[0] == "contractor" && $tipo[1] == "index") || ($tipo[0] == "contractor" && $tipo[1] == "show"))
                or (($tipo[0] == "occurrence_clients" && $tipo[1] == "index") || ($tipo[0] == "occurrence_clients" && $tipo[1] == "show"))
                or (($tipo[0] == "importOs" && $tipo[1] == "index") || ($tipo[0] == "importOs" && $tipo[1] == "show"))
                or (($tipo[0] == "log_imports" && $tipo[1] == "index") || ($tipo[0] == "log_imports" && $tipo[1] == "show"))
                or (($tipo[0] == "log_import_errors" && $tipo[1] == "index") || ($tipo[0] == "log_import_errors" && $tipo[1] == "show"))
                or (($tipo[0] == "export" && $tipo[1] == "index") || ($tipo[0] == "export" && $tipo[1] == "show"))
                or (($tipo[0] == "group_user" && $tipo[1] == "index") || ($tipo[0] == "group_user" && $tipo[1] == "show"))
                or (($tipo[0] == "configuration" && $tipo[1] == "index") || ($tipo[0] == "configuration" && $tipo[1] == "show"))
                or (($tipo[0] == "form" && $tipo[1] == "index") || ($tipo[0] == "form" && $tipo[1] == "show"))
                or (($tipo[0] == "occurrence_type_form" && $tipo[1] == "index")
                    || ($tipo[0] == "occurrence_type_form" && $tipo[1] == "show"))
                or (($tipo[0] == "occurrence_type" && $tipo[1] == "index")
                    || ($tipo[0] == "occurrence_type" && $tipo[1] == "show"))
                or (($tipo[0] == "financial" && $tipo[1] == "index") || ($tipo[0] == "financial" && $tipo[1] == "show"))
                or (($tipo[0] == "equipment" && $tipo[1] == "index") || ($tipo[0] == "equipment" && $tipo[1] == "show"))
//                or (($tipo[0] == "cancelamento_status" && $tipo[1] == "index") || ($tipo[0] == "cancelamento_status" && $tipo[1] == "show"))



            ) {
                $regiaoRole->attachPermission($permissionNow);
            }

            //Regras para Administrador
            if (
                $tipo[0] == "occurrences"
                or (
                    ($tipo[0] == "admin" && $tipo[1] == "monitoring_centralsystem") ||
                    ($tipo[0] == "admin" && $tipo[1] == "monitoring") ||
                    ($tipo[0] == "admin" && $tipo[1] == "technical") ||
                    ($tipo[0] == "admin" && $tipo[1] == "monitoring_gastos_materiais") ||
                    ($tipo[0] == "admin" && $tipo[1] == "dashboard")
                )
                or ($tipo[0] == "users")
                or ($tipo[0] == "report")
                or ($tipo[0] == "skill")
                or ($tipo[0] == "calendar")
//                or ($tipo[0] == "log")
                or ($tipo[0] == "equipment")
                or ($tipo[0] == "cancelamento_status")
                or ($tipo[0] == "alerts")
//                or ($tipo[0] == "operator")
                or ($tipo[0] == "document")
                or ($tipo[0] == "routing")
                or ($tipo[0] == "plan_occurrences")
                or ($tipo[0] == "zone")
                or (($tipo[0] == "contractor_district" && $tipo[1] == "contractor_district") || ($tipo[0] == "contractor_district" && $tipo[1] == "show") || ($tipo[0] == "contractor_district" && $tipo[1] == "edit") || ($tipo[0] == "contractor_district" && $tipo[1] == "create"))
                or (($tipo[0] == "contractor_occurrence_type" && $tipo[1] == "index") || ($tipo[0] == "contractor_occurrence_type" && $tipo[1] == "show") || ($tipo[0] == "contractor_occurrence_type" && $tipo[1] == "edit") || ($tipo[0] == "contractor_occurrence_type" && $tipo[1] == "create"))
                or (($tipo[0] == "vehicles" && $tipo[1] == "index") || ($tipo[0] == "vehicles" && $tipo[1] == "show") || ($tipo[0] == "vehicles" && $tipo[1] == "edit") || ($tipo[0] == "vehicles" && $tipo[1] == "create") || ($tipo[0] == "vehicles" && $tipo[1] == "checklist"))
                or (($tipo[0] == "operator" && $tipo[1] == "index") || ($tipo[0] == "operator" && $tipo[1] == "show") || ($tipo[0] == "operator" && $tipo[1] == "edit") || ($tipo[0] == "operator" && $tipo[1] == "create"))
                or (($tipo[0] == "occurrence" && $tipo[1] == "index") || ($tipo[0] == "occurrence" && $tipo[1] == "create") || ($tipo[0] == "occurrence" && $tipo[1] == "show") || ($tipo[0] == "occurrence" && $tipo[1] == "edit"))
                or (($tipo[0] == "team" && $tipo[1] == "index") || ($tipo[0] == "team" && $tipo[1] == "create") || ($tipo[0] == "team" && $tipo[1] == "show") || ($tipo[0] == "team" && $tipo[1] == "edit"))
                or (($tipo[0] == "occurrence_clients" && $tipo[1] == "index") || ($tipo[0] == "occurrence_clients" && $tipo[1] == "show") || ($tipo[0] == "occurrence_clients" && $tipo[1] == "create") || ($tipo[0] == "occurrence_clients" && $tipo[1] == "edit"))
                or (($tipo[0] == "financial" && $tipo[1] == "index") || ($tipo[0] == "financial" && $tipo[1] == "show") || ($tipo[0] == "financial_item" && $tipo[1] == "edit"))
//                or (($tipo[0] == "document" && $tipo[1] == "index") || ($tipo[0] == "document" && $tipo[1] == "create") || ($tipo[0] == "document" && $tipo[1] == "show") || ($tipo[0] == "document" && $tipo[1] == "edit"))
                or (($tipo[0] == "importOs" && $tipo[1] == "index") || ($tipo[0] == "importOs" && $tipo[1] == "show"))
                or (($tipo[0] == "log_imports" && $tipo[1] == "index") || ($tipo[0] == "log_imports" && $tipo[1] == "show"))
                or (($tipo[0] == "log_import_errors" && $tipo[1] == "index") || ($tipo[0] == "log_import_errors" && $tipo[1] == "show"))
                or (($tipo[0] == "export" && $tipo[1] == "index") || ($tipo[0] == "export" && $tipo[1] == "show"))
                or (($tipo[0] == "occurrence_type_form" && $tipo[1] == "index")
                    || ($tipo[0] == "occurrence_type_form" && $tipo[1] == "show"))
                or (($tipo[0] == "occurrence_type" && $tipo[1] == "index")
                    || ($tipo[0] == "occurrence_type" && $tipo[1] == "show"))
                or (($tipo[0] == "occurrence_type" && $tipo[1] == "create")
                    || ($tipo[0] == "occurrence_type" && $tipo[1] == "edit")
                    || ($tipo[0] == "occurrence_type" && $tipo[1] == "destroy")
                )
//                or (($tipo[0] == "cancelamento_status" && $tipo[1] == "index") || ($tipo[0] == "cancelamento_status" && $tipo[1] == "show"))
                or (($tipo[0] == "interference" && $tipo[1] == "index") || ($tipo[0] == "interference" && $tipo[1] == "show") || ($tipo[0] == "interference" && $tipo[1] == "create") || ($tipo[0] == "interference" && $tipo[1] == "relatorio"))
                or (($tipo[0] == "form" && $tipo[1] == "index")
                    || ($tipo[0] == "form" && $tipo[1] == "show")
                    || ($tipo[0] == "form" && $tipo[1] == "create")
                    || ($tipo[0] == "form" && $tipo[1] == "edit")
                )
                or (($tipo[0] == "form_group" && $tipo[1] == "edit") ||
                    ($tipo[0] == "form_group" && $tipo[1] == "create"))
                or (
                    ($tipo[0] == "form_section" && $tipo[1] == "create")
                    || ($tipo[0] == "form_section" && $tipo[1] == "edit")
                    || ($tipo[0] == "form_section" && $tipo[1] == "destroy")
                )

            ) {
                $adminRole->attachPermission($permissionNow);
            }

            //Regras para supervisor
            if (
                $tipo[0] == "occurrences"
                or ($tipo[0] == "admin")
                or (($tipo[0] == "occurrence" && $tipo[1] == "index") || ($tipo[0] == "occurrence" && $tipo[1] == "show"))
                or (($tipo[0] == "team" && $tipo[1] == "index") || ($tipo[0] == "team" && $tipo[1] == "show"))
//                or (($tipo[0] == "export" && $tipo[1] == "index") || ($tipo[0] == "export" && $tipo[1] == "show"))
                or (($tipo[0] == "document" && $tipo[1] == "index") || ($tipo[0] == "document" && $tipo[1] == "show"))
                or (($tipo[0] == "operator" && $tipo[1] == "index") || ($tipo[0] == "operator" && $tipo[1] == "show"))
            ) {
                $supervisorRole->attachPermission($permissionNow);
            }

            //Regras para Gestor
            if (
                ($tipo[0] == "admin")
                or ($tipo[0] == "log")
                or ($tipo[0] == "occurrences")
                or (($tipo[0] == "occurrence" && $tipo[1] == "index") || ($tipo[0] == "occurrence" && $tipo[1] == "show"))
                or (($tipo[0] == "users" && $tipo[1] == "index") || ($tipo[0] == "users" && $tipo[1] == "show"))
                or (($tipo[0] == "operator" && $tipo[1] == "index") || ($tipo[0] == "operator" && $tipo[1] == "show") || ($tipo[0] == "operator" && $tipo[1] == "edit"))
                or (($tipo[0] == "occurrence_clients" && $tipo[1] == "index") || ($tipo[0] == "occurrence_clients" && $tipo[1] == "show") || ($tipo[0] == "occurrence_clients" && $tipo[1] == "edit"))
                or (($tipo[0] == "document" && $tipo[1] == "index") || ($tipo[0] == "document" && $tipo[1] == "show"))
                or (($tipo[0] == "importOs" && $tipo[1] == "index") || ($tipo[0] == "importOs" && $tipo[1] == "show"))
                or (($tipo[0] == "log_imports" && $tipo[1] == "index") || ($tipo[0] == "log_imports" && $tipo[1] == "show"))
                or (($tipo[0] == "log_import_errors" && $tipo[1] == "index") || ($tipo[0] == "log_import_errors" && $tipo[1] == "show"))
                or (($tipo[0] == "export" && $tipo[1] == "index") || ($tipo[0] == "export" && $tipo[1] == "show"))
                or (($tipo[0] == "form" && $tipo[1] == "index") || ($tipo[0] == "form" && $tipo[1] == "show"))
                or (($tipo[0] == "occurrence_type_form" && $tipo[1] == "index") || ($tipo[0] == "occurrence_type_form" && $tipo[1] == "show"))
                or (($tipo[0] == "occurrence_type" && $tipo[1] == "index") || ($tipo[0] == "occurrence_type" && $tipo[1] == "show"))
                or (($tipo[0] == "equipment" && $tipo[1] == "index") || ($tipo[0] == "equipment" && $tipo[1] == "show"))
            ) {
                $gestorRole->attachPermission($permissionNow);
            }


            //Regras para Financeiro
            if (
                $tipo[0] == "occurrences"
                or ($tipo[0] == "admin")
                //or (($tipo[0] == "export" && $tipo[1] == "index") || ($tipo[0] == "export" && $tipo[1] == "show"))
                or (($tipo[0] == "occurrence" && $tipo[1] == "index") || ($tipo[0] == "occurrence" && $tipo[1] == "show"))
            ) {
                $financeiroRole->attachPermission($permissionNow);
            }
        }
    }
}
