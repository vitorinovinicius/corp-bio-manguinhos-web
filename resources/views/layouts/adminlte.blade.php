<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Central System {{env('APP_ENV')}} @yield('title')</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.6 -->
    <link rel="stylesheet" href="{{ url('/bower_components/AdminLTE/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ url('/css/admin.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
@yield('css')
<!-- Theme style -->
    <link rel="stylesheet" href="{{ url('/bower_components/humane/themes/original.css') }}">

    {{--<link rel="stylesheet" href="{{ url('/bower_components/AdminLTE/dist/css/skins/skin-blue.min.css">--}}
    <link rel="stylesheet" href="{{ url('/css/skins/skin-red.min.css') }}">

    {{-- Humane --}}
    <link rel="stylesheet" href="{{ url('/bower_components/AdminLTE/dist/css/AdminLTE.min.css') }}">

    <!-- Pace style -->
    <link rel="stylesheet" href="{{ url('/bower_components/AdminLTE/plugins/pace/pace.min.css') }}">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-123048358-1"></script>
    <script nonce="{{ csp_nonce() }}">
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }

        gtag('js', new Date());

        gtag('config', 'UA-123048358-1');
    </script>
</head>


@if(app('router')->is("admin.dashboard"))
    <body id="menu-principal" class="hold-transition skin-red sidebar-mini sidebar-collapse">
    @else
        <body id="menu-principal" class="hold-transition skin-red sidebar-mini {{(isset($_COOKIE["menu"]) && !empty($_COOKIE["menu"]) && $_COOKIE["menu"]=="collapsed")? "sidebar-collapse" : ""}}">
        @endif

        <div class="wrapper" id="fullScreen">

            <!-- Main Header -->
            <header class="main-header">

                <!-- Logo -->
                <a href="{{route("admin.index")}}" class="logo">
                    <!-- mini logo for sidebar mini 50x50 pixels -->
                    <span class="logo-mini" title="Central System"><b>CS</b></span>
                    <!-- logo for regular state and mobile devices -->
                    <span class="logo-lg" title="Central System"><b>Central </b>System</span>
                </a>

                <!-- Header Navbar -->
                <nav class="navbar navbar-static-top" role="navigation">
                    <!-- Sidebar toggle button-->
                    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                        <span class="sr-only">Toggle navigation</span>
                    </a>
                    <!-- Navbar Right Menu -->
                    <div class="navbar-custom-menu">
                        <ul class="nav navbar-nav">
                            <!-- User Account Menu -->
                            <li class="dropdown user user-menu">
                                <!-- Menu Toggle Button -->
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <!-- The user image in the navbar-->
                                    <img src="{{ asset('/css/images/avatar1.png') }}" class="user-image" alt="User Image">
                                    <!-- hidden-xs hides the username on small devices so only the image appears. -->
                                    <span class="hidden-xs">{{Auth::user()->name}}</span>
                                </a>
                                <ul class="dropdown-menu">
                                    <!-- The user image in the menu -->
                                    <li class="user-header">
                                        <img src="{{ asset('/css/images/avatar1.png') }}" class="img-circle" alt="User Image">

                                        <p>
                                            {{Auth::user()->name}}
                                        </p>
                                    </li>
                                    <!-- Menu Footer-->
                                    <li class="user-footer">
                                        <div class="pull-right">
                                            <a href="{{ url('/logout') }}" class="btn btn-default btn-flat"
                                               onclick="event.preventDefault();
                                                     document.getElementById('logout-form2').submit();">
                                                Sair
                                            </a>

                                            <form id="logout-form2" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                                {{ csrf_field() }}
                                            </form>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </nav>
            </header>
            <!-- Left side column. contains the logo and sidebar -->
            <aside class="main-sidebar">

                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">

                    <!-- Sidebar user panel (optional) -->
                    <div class="user-panel">
                        <div class="pull-left image">
                            <img src="{{ url('/css/images/avatar1.png') }}" class="img-circle" alt="User Image">
                        </div>
                        <div class="pull-left info">
                            <p>{{Auth::user()->name}}</p>
                        </div>
                    </div>

                    <!-- Sidebar Menu -->
                    <ul class="sidebar-menu">

                        <li class="treeview
                            @if(
                                app('router')->is("admin.monitoring")
                                or app('router')->is("admin.monitoring_nts")
                                or app('router')->is("admin.technical")
                                or app('router')->is("admin.dashboard")
                                or app('router')->is("alerts.index")
                                or app('router')->is("interferences.relatorio")
                                )
                        {{"active"}}
                        @endif
                                ">
                            <a href="#">
                                <i class="bx bx-line-chart"></i> <span>Dashboards</span>
                                <span class="pull-right-container">
                            <i class="bx bx-angle-left pull-right"></i>
                        </span>
                            </a>
                            <ul class="treeview-menu">
                                @shield('admin.monitoring')
                                <li class="{{(app('router')->is("admin.monitoring"))? "active": ""}}">
                                    <a href="{{route("admin.monitoring")}}"><i class="bx bx-map-o"></i><span>Monitoramento</span></a>
                                </li>
                                @endshield

                                @shield('admin.monitoring_nts')
                                <li class="{{(app('router')->is("admin.monitoring_nts"))? "active": ""}}">
                                    <a href="{{route("admin.monitoring_nts")}}"><i class="bx bx-map"></i><span>Monitoramento Empresas</span></a>
                                </li>
                                @endshield

                                @shield('admin.technical')
                                <li class="{{(app('router')->is("admin.technical"))? "active": ""}}">
                                    <a href="{{route("admin.technical")}}"><i class="bx bx-cubes"></i>
                                        <span>Técnicos</span></a></li>
                                @endshield

                                @shield('admin.dashboard')
                                <li class="{{(app('router')->is("admin.dashboard"))? "active": ""}}">
                                    <a href="{{route("admin.dashboard")}}"><i class="bx bx-desktop"></i><span>Relatórios diversos</span></a>
                                </li>
                                @endshield
                                @shield('alerts.index')
                                <li class="{{(Route::is("alerts.index"))? "active": ""}}">
                                    <a href="{{route("alerts.index")}}"><i class="bx bx-exclamation-triangle"></i>Alertas</a>
                                </li>
                                @endis

                                @shield('interference.relatorio')
                                <li class="{{(app('router')->is("interferences.relatorio"))? "active": ""}}">
                                    <a href="{{route("interferences.relatorio")}}"><i class="bx bx-exclamation-circle"></i>Relatório de Interferências</a>
                                </li>
                                @endshield
                            </ul>
                        </li>
                        <li class="treeview
                    @if(app('router')->is("occurrences*") OR app('router')->is("admin.occurrences*")) {{"active"}} @endif ">
                            <a href="#">
                                <i class="bx bx-gear"></i> <span>Serviços</span>
                                <span class="pull-right-container">
                            <i class="bx bx-angle-left pull-right"></i>
                        </span>
                            </a>
                            <ul class="treeview-menu">
                                @shield('occurrence.create')
                                <li class="{{(app('router')->is("occurrences.create"))? "active": ""}}">
                                    <a href="{{route("occurrences.create")}}">Nova OS
                                        <span class="label label-success">new</span></a></li>
                                @endshield
                                @shield('occurrence.index')
                                <li class="{{(app('router')->is("occurrences*"))? "active": ""}}" data-toggle="tooltip" title="Lista todas as Ocorrências">
                                    <a href="{{route("occurrences.index")}}">Todos</a></li>
                                @endshield
                                @shield('occurrences.unassigned')
                                <li class="{{(app('router')->is("admin.occurrences.unassigned"))? "active": ""}}" data-toggle="tooltip" title="Lista as Ocorrências de hoje e futuras que foram importadas mas ainda não atribuídas a algum técnico">
                                    <a href="{{route("admin.occurrences.unassigned")}}">Não atribuídos</a></li>
                                @endshield
                                @shield('occurrences.pending')
                                <li class="{{(app('router')->is("admin.occurrences.pending"))? "active": ""}}" data-toggle="tooltip" title="Lista as Ocorrências pendentes do dia e futuras que foram associadas ao técnico, porém ainda não foram executadas">
                                    <a href="{{route("admin.occurrences.pending")}}">Pendentes</a></li>
                                @endshield
                                @shield('occurrences.closed')
                                <li class="{{(app('router')->is("admin.occurrences.closed"))? "active": ""}}" data-toggle="tooltip" title="Lista todas as Ocorrências realizadas">
                                    <a href="{{route("admin.occurrences.closed")}}">Realizados</a></li>
                                @endshield
                                @shield('occurrences.closed_unsolved')
                                <li class="{{(app('router')->is("admin.occurrences.closed_unsolved"))? "active": ""}}" data-toggle="tooltip" title="Lista todas as Ocorrências Canceladas/Não realizadas">
                                    <a href="{{route("admin.occurrences.closed_unsolved")}}">Não realizados</a></li>
                                @endshield
                                @shield('occurrences.pending')
                                <li class="{{(app('router')->is("admin.occurrences.not_executed"))? "active": ""}}" data-toggle="tooltip" title="Lista as Ocorrências do dia anterior e passadas que não foram executadas">
                                    <a href="{{route("admin.occurrences.not_executed")}}">Não executadas</a></li>
                                @endshield
                                @shield('occurrences.pending')
                                <li class="{{(app('router')->is("admin.occurrences.status_schedule"))? "active": ""}}" data-toggle="tooltip" title="Lista as Ocorrências que necessitam de reagendamento">
                                    <a href="{{route("admin.occurrences.status_schedule")}}">Reagendar</a></li>
                                @endshield
                            </ul>
                        </li>
                        <li class="treeview
                            @if(
                                app('router')->is("admin.occurrences.to_approved")
                                OR app('router')->is("admin.occurrences.approved")
                                OR app('router')->is("admin.occurrences.to_adjust")
                                OR app('router')->is("admin.occurrences.adjusted")
                                OR app('router')->is("admin.occurrences.disapproved")
                                OR app('router')->is("financials*")
                            ) {{"active"}} @endif ">
                            <a href="#">
                                <i class="bx bx-money"></i>
                                <span>Conclusão </span>
                                <span class="pull-right-container"><i class="bx bx-angle-left pull-right"></i></span>
                            </a>
                            <ul class="treeview-menu">
                                @shield('financial.dashboard')
                                <li class="{{(app('router')->is("financials.dashboard"))? "active": ""}}" data-toggle="tooltip" title="Monitoramento da conclusão">
                                    <a href="{{route("financials.dashboard")}}">Monitoramento</a></li>
                                @endshield
                                @shield('occurrences.to_approved')
                                <li class="{{(app('router')->is("admin.occurrences.to_approved"))? "active": ""}}" data-toggle="tooltip" title="Lista as Ocorrências finalizadas que estão pendentes da aprovação">
                                    <a href="{{route("admin.occurrences.to_approved")}}">Pendente de aprovação</a></li>
                                @endshield
                                @shield('occurrences.approved')
                                <li class="{{(app('router')->is("admin.occurrences.approved"))? "active": ""}}" data-toggle="tooltip" title="Lista as Ocorrências finalizadas que já estão aprovadas pelo administrador">
                                    <a href="{{route("admin.occurrences.approved")}}">Aprovado</a></li>
                                @endshield
                                @shield('occurrences.to_adjust')
                                <li class="{{(app('router')->is("admin.occurrences.to_adjust"))? "active": ""}}" data-toggle="tooltip" title="Lista as Ocorrências que foram solicitado ajustes">
                                    <a href="{{route("admin.occurrences.to_adjust")}}">Para empresa ajustar</a>
                                </li>
                                @endshield
                                @shield('occurrences.adjusted')
                                <li class="{{(app('router')->is("admin.occurrences.adjusted"))? "active": ""}}" data-toggle="tooltip" title="Lista as Ocorrências que foram ajustadas pela empresa">
                                    <a href="{{route("admin.occurrences.adjusted")}}">Ajustado pela empresa</a>
                                </li>
                                @endshield
                                @shield('occurrences.disapproved')
                                <li class="{{(app('router')->is("admin.occurrences.disapproved"))? "active": ""}}" data-toggle="tooltip" title="Lista as Ocorrências que foram rejeitadas">
                                    <a href="{{route("admin.occurrences.disapproved")}}">Reprovadas</a>
                                </li>
                                @endshield

                                @shield('financial.index')
                                <li class="{{(app('router')->is("financials.index"))? "active": ""}}">
                                    <a href="{{route("financials.index")}}">Interações</a></li>
                                @endshield
                            </ul>
                        </li>

                        <li class="treeview
                                @if(
                                    app('router')->is("occurrence_clients*")
                                ) {{"active"}} @endif ">
                            <a href="#">
                                <i class="bx bx-street-view"></i>
                                <span>Clientes </span>
                                <span class="pull-right-container"><i class="bx bx-angle-left pull-right"></i></span>
                            </a>
                            <ul class="treeview-menu">
                                @shield('occurrence_clients.create')
                                <li class="{{(app('router')->is("occurrence_clients.create"))? "active": ""}}">
                                    <a href="{{route("occurrence_clients.create")}}">Novo Cliente
                                        <span class="label label-success">new</span></a></li>
                                @endshield
                                @shield('occurrence_clients.index')
                                <li class="{{(app('router')->is("occurrence_clients.index"))? "active": ""}}">
                                    <a href="{{route("occurrence_clients.index")}}">Todos</a></li>
                                @endshield
                            </ul>
                        </li>
                        @if(
                        \Artesaos\Defender\Facades\Defender::hasPermission('importOs.index') ||
                        \Artesaos\Defender\Facades\Defender::hasPermission('log_imports.index') ||
                        \Artesaos\Defender\Facades\Defender::hasPermission('log_import_errors.index') ||
                       \Artesaos\Defender\Facades\Defender::hasRole('regiao')
                        )
                            <li class="treeview
                                @if(
                                    app('router')->is("importOs*")
                                    OR app('router')->is("log_imports*")
                                    OR app('router')->is("log_import_errors*")
                                ) {{"active"}} @endif ">
                                <a href="#">
                                    <i class="bx bx-upload"></i>
                                    <span>Importação </span>
                                    <span class="pull-right-container"><i class="bx bx-angle-left pull-right"></i></span>
                                </a>
                                <ul class="treeview-menu">
                                    @shield('importOs.index')
                                    <li class="{{(app('router')->is("importOs.index"))? "active": ""}}">
                                    <a href="{{route("importOs.index")}}">Importar OS</a></li>
                                    @endshield
                                    {{--@shield('importOs.import_nts')--}}
                                    {{--<li class="{{(app('router')->is("importOs.import_nts"))? "active": ""}}">--}}
                                        {{--<a href="{{route("importOs.import_nts")}}">Importar OS Pessoais</a></li>--}}
                                    {{--@endshield--}}
                                    @shield('log_imports.index')
                                    <li class="{{(app('router')->is("log_imports*"))? "active": ""}}">
                                        <a href="{{route("log_imports.index")}}">Logs de Importação</a></li>
                                    @endshield
                                    @shield('log_import_errors.index')
                                    <li class="{{(app('router')->is("log_import_errors*"))? "active": ""}}">
                                        <a href="{{route("log_import_errors.index")}}">Logs de erros</a></li>
                                    @endshield
                                </ul>
                            </li>

                        @endif
                        @shield('export.index')
                        <li class="{{(app('router')->is("export*"))? "active": ""}}">
                            <a href="{{route("export.index")}}"><i class="bx bx-download"></i><span>Exportação de OS</span></a>
                        </li>
                        @endshield

                        {{--@is(['admin','superuser','regiao','gestor'])--}}
                        <li class="treeview
                        @if(
                            app('router')->is("users*")
                            OR app('router')->is("group_user*")
                            OR app('router')->is("teams*")
                            OR app('router')->is("operators*")
                            OR app('router')->is("operator*")
                        ) {{"active"}} @endif
                                ">
                            <a href="#">
                                <i class="bx bx-users"></i> <span>Usuários </span>
                                <span class="pull-right-container">
                                <i class="bx bx-angle-left pull-right"></i>
                            </span>
                            </a>
                            <ul class="treeview-menu">
                                @shield('users.index')
                                <li class="{{(app('router')->is("users*"))? "active": ""}}">
                                    <a href="{{route("users.index")}}">Usuários</a></li>
                                @endshield
                                @shield('group-user')
                                <li class="{{(app('router')->is("group_user*"))? "active": ""}}">
                                    <a href="{{route("group_user.index")}}">Grupos de usuário</a></li>
                                @endshield
                                @shield('team.index')
                                <li class="{{(app('router')->is("teams*"))? "active": ""}}">
                                    <a href="{{route("teams.index")}}">Equipes</a></li>
                                @endshield
                                @shield('operator.index')
                                <li class="{{(app('router')->is("operators*"))? "active": ""}}">
                                    <a href="{{route("operators.index")}}">Técnicos</a>
                                </li>
                                <li class="{{(app('router')->is("operator.*"))? "active": ""}}">
                                    <a href="{{route("rh.export")}}">Exportação RH</a>
                                </li>
                                @endshield
                            </ul>
                        </li>
                        @if(
                          \Artesaos\Defender\Facades\Defender::hasPermission('vehicles.index') ||
                          \Artesaos\Defender\Facades\Defender::hasPermission('vehicles.checklist')
                          )

                            <li class="treeview
                                @if(
                                    app('router')->is("vehicles*")
                                ) {{"active"}} @endif
                                    ">
                                <a href="#">
                                    <i class="bx bx-car"></i> <span>Veículos </span>
                                    <span class="pull-right-container">
                                <i class="bx bx-angle-left pull-right"></i>
                            </span>
                                </a>
                                <ul class="treeview-menu">
                                    @shield('vehicles.index')
                                    <li class="{{(app('router')->is("vehicles.index"))? "active": ""}}">
                                        <a href="{{route("vehicles.index")}}">Veículos</a></li>
                                    @endshield
                                    @shield('vehicles.checklist')
                                    <li class="{{(app('router')->is("vehicles.checklist"))? "active": ""}}">
                                        <a href="{{route("vehicles.checklist")}}">Checklist</a></li>
                                    @endshield

                                </ul>
                            </li>
                        @endif
                        {{--@endis--}}

                        @shield('log.index')
                        <li class="{{(app('router')->is("log*"))? "active": ""}}"><a href="{{route("log.index")}}"><i class="bx bx-calendar-check-o"></i> <span>Auditoria</span></a></li>
                        @endshield

                        <li class="treeview
                            @if(
                                app('router')->is("forms*")
                                OR app('router')->is("form*")
                                OR app('router')->is("documents*")
                                OR app('router')->is("occurrence_types*")
                                OR app('router')->is("cancelamento_statuses*")
                                OR app('router')->is("interferences*")
                                OR app('router')->is("skills*")


                                )
                        {{"active"}}
                        @endif
                                ">
                            <a href="#">
                                <i class="bx bx-key"></i> <span>Administrativo</span>
                                <span class="pull-right-container">
                                    <i class="bx bx-angle-left pull-right"></i>
                                 </span>
                            </a>
                            <ul class="treeview-menu">

                                @shield('occurrence_type.index')
                                <li class="{{(app('router')->is("occurrence_types*"))? "active": ""}}">
                                    <a href="{{route("occurrence_types.index")}}">Tipos de Ocorrências</a></li>
                                @endshield
                                @shield('form.index')
                                <li class="{{(app('router')->is("forms*"))? "active": ""}}">
                                    <a href="{{route("forms.index")}}">Formulários</a></li>
                                @endshield
                                @shield('document.index')
                                <li class="{{(app('router')->is("document*"))? "active": ""}}">
                                    <a href="{{route("documents.index")}}">Documentos</a></li>
                                @endshield
                                @shield('interference.index')
                                <li class="{{(app('router')->is("interferences*"))? "active": ""}}">
                                    <a href="{{route("interferences.index")}}">Interferências</a></li>
                                @endshield
                                @shield('cancelamento_status.index')
                                <li class="{{(app('router')->is("cancelamento_statuses*"))? "active": ""}}">
                                    <a href="{{route("cancelamento_statuses.index")}}">Status de Cancelamento</a>
                                </li>
                                @endshield
                                @shield('skill.index')
                                <li class="{{(app('router')->is("skills*"))? "active": ""}}">
                                    <a href="{{route("skills.index")}}">Habilidades</a>
                                </li>
                                @endshield

                            </ul>
                        </li>


                        @is('superuser')
                        <li class="treeview
                            @if(
                                app('router')->is("configurations*")
                                OR app('router')->is("contractor_occurrence_types*")
                                OR app('router')->is("permissions*")
                                OR app('router')->is("roles*")
                                OR app('router')->is("app_versions*")
                                OR app('router')->is("forms*")
                                OR app('router')->is("form_groups*")
                                OR app('router')->is("occurrence_type_forms*")
                                OR app('router')->is("sms*")
                                OR app('router')->is("log_locals*")

                                OR app('router')->is("configuration*")
                                OR app('router')->is("plans*")
                                OR app('router')->is("districts*")
                                OR app('router')->is("contractor_districts*")
                                OR app('router')->is("contractors*")
                                OR app('router')->is("finish_work_days*")
                                OR app('router')->is("equipments*")

                                )
                        {{"active"}}
                        @endif
                                ">
                            <a href="#">
                                <i class="bx bx-key"></i> <span>Central System</span>
                                <span class="pull-right-container">
                            <i class="bx bx-angle-left pull-right"></i>
                        </span>
                            </a>
                            <ul class="treeview-menu">

                                @shield('contractor.index')
                                <li class="{{(app('router')->is("contractors*"))? "active": ""}}">
                                    <a href="{{route("contractors.index")}}">Empresas</a></li>
                                @endshield
                                @shield('contractor_occurrence_type.index')
                                <li class="{{(app('router')->is("contractor_occurrence_types*"))? "active": ""}}">
                                    <a href="{{route("contractor_occurrence_types.index")}}">Empresas x Ocorrências</a>
                                </li>
                                @endshield
                                @shield('district.index')
                                <li class="{{(app('router')->is("districts*"))? "active": ""}}">
                                    <a href="{{route("districts.index")}}">Bairros</a>
                                </li>
                                @endshield
                                @shield('contractor_district.index')
                                <li class="{{(app('router')->is("contractor_districts*"))? "active": ""}}">
                                    <a href="{{route("contractor_districts.index")}}">Empresa x Bairros</a>
                                </li>
                                @endshield

                                @shield('configuration.index')
                                <li class="{{(app('router')->is("configurations*"))? "active": ""}}">
                                    <a href="{{route("configurations.index")}}">Configurações</a></li>
                                @endshield

                                <li class="{{(app('router')->is("permissions*"))? "active": ""}}">
                                    <a href="{{route("permissions.index")}}">Permissões</a></li>
                                <li class="{{(app('router')->is("roles*"))? "active": ""}}">
                                    <a href="{{route("roles.index")}}">Perfil (regras)</a></li>
                                <li class="{{(app('router')->is("app_versions*"))? "active": ""}}">
                                    <a href="{{route("app_versions.index")}}">App Versão</a></li>
                                <li class="{{(app('router')->is("sms*"))? "active": ""}}">
                                    <a href="{{route("sms.index")}}">SMS</a></li>
                                <li class="{{(app('router')->is("log_locals*"))? "active": ""}}">
                                    <a href="{{route("log_locals.index")}}">Log Android</a></li>
                                @shield('finish_work_days.index')
                                <li class="{{(app('router')->is("finish_work_days*"))? "active": ""}}">
                                    <a href="{{route("finish_work_days.index")}}">Jornada do Dia</a></li>
                                @endshield

                                <li class="header">FORMULÁRIOS</li>
                                @shield('form.index')
                                <li class="{{(app('router')->is("forms*"))? "active": ""}}">
                                    <a href="{{route("forms.index")}}">Formulários</a></li>
                                @endshield
                                @shield('occurrence_type_form.index')
                                <li class="{{(app('router')->is("occurrence_type_forms*"))? "active": ""}}">
                                    <a href="{{route("occurrence_type_forms.index")}}">Assoçiação de formulários</a>
                                </li>
                                @endshield
                            </ul>
                        </li>
                        @endis
                        <li>
                            <a href="http://suporte.centralsystem.com.br" target="_blank"><i class="bx bx-wrench"></i>
                                <span>Suporte</span></a>
                        </li>
                        <li>
                            <a href="{{ url('/logout') }}"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="bx bx-sign-out"></i> <span>Sair</span>
                            </a>
                            <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </li>
                    </ul>
                    <!-- /.sidebar-menu -->
                </section>
                <!-- /.sidebar -->
            </aside>

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    @yield('header')
                </section>

                @if( optional(Auth::user()->contractor)->financial_pendency == 1)
                    <div class="pad margin no-print">
                        <div class="callout callout-danger" style="margin-bottom: 0!important;">
                            <h4><i class="bx bx-info"></i> ATENÇÃO !</h4>
                            <p><strong>EVITE O BLOQUEIO DA SUA PLATAFORMA CENTRAL SYSTEM.</strong></p>
                            <p>Consta em nosso sistema financeiro, debito de vossa empresa.
                                Favor entrar em contato com financeiro@centralsystem.com.br </p>

                            <p>Caso seu débito já tenha sido regularizado, favor desconsiderar esta mensagem. </p>

                            <p>Grato, <br>
                                Diretoria Financeira.</p>
                        </div>
                    </div>
            @endif

            <!-- Main content -->
                <section class="content">
                    <!-- Your Page Content Here -->
                    @yield('content')
                </section>
                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->

            <!-- Main Footer -->
            <footer class="main-footer">
                <!-- To the right -->
                <div class="pull-right hidden-xs">
                    Central System
                </div>
                <!-- Default to the left -->
                <strong>Copyright &copy; {{ date("Y")  }}
                    <a href="http://centralsystem.com.br" target="_blank">Central System</a>.</strong> Todos os direitos reservados.
            </footer>

            <!-- /.control-sidebar -->
            <!-- Add the sidebar's background. This div must be placed
                 immediately after the control sidebar -->
            <div class="control-sidebar-bg"></div>
        </div>
        <!-- ./wrapper -->

        <!-- REQUIRED JS SCRIPTS -->

        <!-- jQuery 2.2.3 -->
        <script src="{{ url('/bower_components/AdminLTE/plugins/jQuery/jquery-2.2.3.min.js') }}"></script>
        <!-- Jquery UI -->
        <script src="{{ url('/bower_components/jquery-ui/jquery-ui.min.js') }}"></script>
        <!-- Bootstrap 3.3.6 -->
        <script src="{{ url('/bower_components/AdminLTE/bootstrap/js/bootstrap.min.js') }}"></script>
        <!-- AdminLTE App -->
        <script src="{{ url('/bower_components/AdminLTE/dist/js/app.min.js') }}"></script>
        <script src="{{ url('/bower_components/AdminLTE/dist/js/demo.js') }}"></script>


        <!-- Humane-->
        <script src="{{ url('/bower_components/humane/humane.min.js') }}"></script>

        {{--JQUERY COOKIE--}}
        <script src="{{ url('/js/js.cookie.js') }}"></script>

        <!-- PACE -->
        <script src="{{ url('/bower_components/AdminLTE/plugins/pace/pace.min.js') }}"></script>

        @yield('scripts')
        @yield('scripts2')
        @yield('scripts_extra')
        <script type="text/javascript" nonce="{{ csp_nonce() }}">
            $('[data-toggle="popover"]').popover()


            $(document).on("click", ".sidebar-toggle", function (e) {
                e.preventDefault();
                if ($("#menu-principal").hasClass("sidebar-collapse")) {
                    Cookies.remove("menu");
                } else {
                    Cookies.set("menu", "collapsed");
                }
            });
        </script>

        @if(app('router')->is("admin.dashboard"))
        </body>
        @else
    </body>
@endif
</html>
