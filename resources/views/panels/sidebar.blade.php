{{-- vertical-menu --}}
@if($configData['mainLayoutType'] == 'vertical-menu')
<div class="main-menu menu-fixed @if($configData['theme'] === 'light') {{"menu-light"}} @else {{'menu-dark'}} @endif menu-accordion menu-shadow" data-scroll-to-active="true">
      <div class="navbar-header">
      <ul class="nav navbar-nav flex-row">
      <li class="nav-item mr-auto">
          <a class="navbar-brand" href="{{asset('/')}}">
          <div class="brand-logo">
            {{--<img src="{{asset('images/logo/logo.png')}}" class="logo" alt="">--}}
          </div>
          <h2 class="brand-text mb-0">
            @if(!empty($configData['templateTitle']) && isset($configData['templateTitle']))
            {{$configData['templateTitle']}}
            @else
            Bio-Manguinhos
            @endif
          </h2>
          </a>
      </li>
          <li class="nav-item nav-toggle">
          <a class="nav-link modern-nav-toggle pr-0" data-toggle="collapse">
            <i class="bx bx-x d-block d-xl-none font-medium-4 primary"></i>
            <i class="toggle-icon bx bx-disc font-medium-4 d-none d-xl-block primary" data-ticon="bx-disc"></i>
          </a>
          </li>
      </ul>
      </div>
      <div class="shadow-bottom"></div>
      <div class="main-menu-content">
      <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation" data-icon-style="lines">
        <li class="nav-item @if(app('router')->is("word.index")){{"active"}}@endif">
            <a href="#">
                <i class="menu-livicon" data-icon="box"></i>
                <span class="menu-title">Relatórios</span>
            </a>
            <ul class="menu-content"> 
                <li class="{{(app('router')->is("word.index"))? "active": ""}}">
                    <a href="{{route("word.index")}}">
                        <i class="bx bx-right-arrow-alt"></i>
                        <span class="menu-item">Todos</span>
                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-item @if(app('router')->is("word.index")){{"active"}}@endif">
            <a href="#">
                <i class="menu-livicon" data-icon="envelope-pull"></i>
                <span class="menu-title">E-mail</span>
            </a>
            <ul class="menu-content"> 
                <li class="{{(app('router')->is("word.index"))? "active": ""}}">
                    <a href="{{route("word.index")}}">
                        <i class="bx bx-right-arrow-alt"></i>
                        <span class="menu-item">Enviados</span>
                    </a>
                </li>
                <li class="{{(app('router')->is("word.index"))? "active": ""}}">
                    <a href="{{route("word.index")}}">
                        <i class="bx bx-right-arrow-alt"></i>
                        <span class="menu-item">Confirmados</span>
                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-item @if(
            app('router')->is("forms*")
        ){{"active"}}@endif">
            <a href="#">
                <i class="menu-livicon" data-icon="briefcase"></i>
                <span class="menu-title">Formulários</span>
            </a>
            <ul class="menu-content">
                  @shield('form.index')
                  <li class="{{(app('router')->is("forms.index"))? "active": ""}}">
                      <a href="{{route("forms.index")}}">
                          <i class="bx bx-right-arrow-alt"></i>
                          <span class="menu-item">Todos</span>
                      </a>
                  </li>
                  <li class="{{(app('router')->is("forms.preenchimento"))? "active": ""}}">                    
                    <a href="{{route("forms.preenchimento")}}">
                        <i class="bx bx-right-arrow-alt"></i>
                        <span class="menu-item">Preenchimento</span>
                    </a>
                  </li>
                  @endshield
            </ul>
        </li>
        @is('superuser')
          <li class="nav-item
            @if(
                app('router')->is("configurations*")
                OR app('router')->is("contractor_occurrence_types*")
                OR app('router')->is("permissions*")
                OR app('router')->is("roles*")
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
          @endif ">
              <a href="#">
                  <i class="menu-livicon" data-icon="gears"></i>
                  <span class="menu-title">Configurações</span>
              </a>

              <ul class="menu-content">                
                  {{-- @shield('contractor.index')
                  <li class="{{(app('router')->is("contractors*"))? "active": ""}}">
                      <a href="{{route("contractors.index")}}">
                          <i class="bx bx-right-arrow-alt"></i>
                          <span class="menu-item">Empresas</span>
                      </a>
                  </li>
                  @endshield --}}
                  @shield('team.index')
                  <li class="{{(app('router')->is("teams*"))? "active": ""}}">
                      <a href="{{route("teams.index")}}">
                          <i class="bx bx-right-arrow-alt"></i>
                          <span class="menu-item">Setores</span>
                      </a>
                  </li>
                  @endshield
                  {{-- @shield('contractor_occurrence_type.index')
                  <li class="{{(app('router')->is("contractor_occurrence_types*"))? "active": ""}}">
                      <a href="{{route("contractor_occurrence_types.index")}}">
                          <i class="bx bx-right-arrow-alt"></i>
                          <span class="menu-item">Empresas x Occorrências</span>
                      </a>
                  </li>
                  @endshield
                  @shield('district.index')
                  <li class="{{(app('router')->is("districts*"))? "active": ""}}">
                      <a href="{{route("districts.index")}}">
                          <i class="bx bx-right-arrow-alt"></i>
                          <span class="menu-item">Bairros</span>
                      </a>
                  </li>
                  @endshield
                  @shield('contractor_district.index')
                  <li class="{{(app('router')->is("contractor_districts*"))? "active": ""}}">
                      <a href="{{route("contractor_districts.index")}}">
                          <i class="bx bx-right-arrow-alt"></i>
                          <span class="menu-item">Empresa x Bairros</span>
                      </a>
                  </li>
                  @endshield
                  @shield('configuration.index')
                  <li class="{{(app('router')->is("configuration*"))? "active": ""}}">
                      <a href="{{route("configuration.index")}}">
                          <i class="bx bx-right-arrow-alt"></i>
                          <span class="menu-item">Configurações</span>
                      </a>
                  </li>
                  @endshield
                  @shield('general_setting.index')
                  <li class="{{(app('router')->is("general_setting*"))? "active": ""}}">
                      <a href="{{route("general_setting.index")}}">
                          <i class="bx bx-right-arrow-alt"></i>
                          <span class="menu-item">Configurações Gerais</span>
                      </a>
                  </li>
                  @endshield --}}

                  <li class="{{(app('router')->is("permissions*"))? "active": ""}}">
                      <a href="{{route("permissions.index")}}">
                          <i class="bx bx-right-arrow-alt"></i>
                          <span class="menu-item">Permissões</span>
                      </a>
                  </li>
                  <li class="{{(app('router')->is("roles*"))? "active": ""}}">
                      <a href="{{route("roles.index")}}">
                          <i class="bx bx-right-arrow-alt"></i>
                          <span class="menu-item">Perfil (regras)</span>
                      </a>
                  </li>

                  {{-- <li class="{{(app('router')->is("sms*"))? "active": ""}}">
                      <a href="{{route("sms.index")}}">
                          <i class="bx bx-right-arrow-alt"></i>
                          <span class="menu-item">SMS</span>
                      </a>
                  </li>
                  <li class="{{(app('router')->is("log_locals*"))? "active": ""}}">
                      <a href="{{route("log_locals.index")}}">
                          <i class="bx bx-right-arrow-alt"></i>
                          <span class="menu-item">Log Android</span>
                      </a>
                  </li>

                  @shield('finish_work_days.index')
                  <li class="{{(app('router')->is("finish_work_days*"))? "active": ""}}">
                      <a href="{{route("finish_work_days.index")}}">
                          <i class="bx bx-right-arrow-alt"></i>
                          <span class="menu-item">Jornada do Dia</span>
                      </a>
                  </li>
                  @endshield

                  @shield('routing.index')
                  <li class="{{(app('router')->is("routing.*"))? "active": ""}}">
                    <a href="{{route("routing.index")}}">
                        <i class="bx bx-right-arrow-alt"></i>
                        <span class="menu-item">Roteirização</span>
                    </a>
                </li>
                  @endshield --}}

                  
                  {{-- @shield('occurrence_type_form.index')
                  <li class="{{(app('router')->is("occurrence_type_forms*"))? "active": ""}}">
                      <a href="{{route("occurrence_type_forms.index")}}">
                          <i class="bx bx-right-arrow-alt"></i>
                          <span class="menu-item">Assoçiação de formulários</span>
                      </a>
                  </li>
                  @endshield --}}
              </ul>
          </li>
          @endis
          {{-- <li class="nav-item
            @if(
                app('router')->is("admin.monitoring")
                or app('router')->is("admin.monitoring_gastos_materiais")
                or app('router')->is("admin.monitoring_nts")
                or app('router')->is("admin.technical")
                or app('router')->is("admin.dashboard")
                or app('router')->is("alerts.index")
                or app('router')->is("interferences.dashboard")
                )
            {{"active"}}
            @endif
                  ">
              <a href="#">
                      <i class="menu-livicon" data-icon="desktop"></i>
                      <span class="menu-title">Dashboard</span>
              </a>

              <ul class="menu-content">
                  @shield('admin.monitoring')
                  <li class="{{(app('router')->is("admin.monitoring"))? "active": ""}}">
                      <a href="{{route("admin.monitoring")}}">
                          <i class="bx bx-right-arrow-alt"></i>
                          <span class="menu-item">Monitoramento</span>
                      </a>
                  </li>
                  @endshield
                  @shield('admin.monitoring_nts')
                  <li class="{{(app('router')->is("admin.monitoring_nts"))? "active": ""}}">
                      <a href="{{route("admin.monitoring_nts")}}">
                          <i class="bx bx-right-arrow-alt"></i>
                          <span class="menu-item">Monitoramento Empresas</span>
                      </a>
                  </li>
                  @endshield
                  @shield('admin.technical')
                  <li class="{{(app('router')->is("admin.technical"))? "active": ""}}">
                      <a href="{{route("admin.technical")}}">
                          <i class="bx bx-right-arrow-alt"></i>
                          <span class="menu-item">Técnicos</span>
                      </a>
                  </li>
                  @endshield
                  @shield('admin.dashboard')
                  <li class="{{(app('router')->is("admin.dashboard"))? "active": ""}}">
                      <a href="{{route("admin.dashboard")}}">
                          <i class="bx bx-right-arrow-alt"></i>
                          <span class="menu-item">Relatórios diversos</span>
                      </a>
                  </li>
                  @endshield
                  @shield('alerts.index')
                  <li class="{{(app('router')->is("alerts.index"))? "active": ""}}">
                      <a href="{{route("alerts.index")}}">
                          <i class="bx bx-right-arrow-alt"></i>
                          <span class="menu-item">Alertas</span>
                      </a>
                  </li>
                  @endshield
                  @shield('interference.relatorio')
                  <li class="{{(app('router')->is("interferences.dashboard"))? "active": ""}}">
                      <a href="{{route("interferences.dashboard")}}">
                          <i class="bx bx-right-arrow-alt"></i>
                          <span class="menu-item">Interferências</span>
                      </a>
                  </li>
                  @endshield
                  @shield('admin.monitoring')
                  @if(Defender::is('cliente'))
                    <li class="{{(app('router')->is("client.index"))? "active": ""}}">
                        <a href="{{route("client.index")}}">
                            <i class="bx bx-right-arrow-alt"></i>
                            <span class="menu-item">Ticket</span>
                        </a>
                    </li>
                    @else
                    <li class="{{(app('router')->is("ticket.index"))? "active": ""}}">
                        <a href="{{route("ticket.index")}}">
                            <i class="bx bx-right-arrow-alt"></i>
                            <span class="menu-item">Ticket</span>
                        </a>
                    </li>
                  @endif
                  @endshield
              </ul>
          </li> --}}
          {{-- @if(!Defender::is('cliente'))
          <li class="nav-item
                    @if(
                    app('router')->is("occurrences*")
                    OR app('router')->is("admin.occurrences*")
                    OR app('router')->is("calendar.index")
                    ) {{"active"}} @endif">
              <a href="#">
                  <i class="menu-livicon" data-icon="gear"></i>
                  <span class="menu-title">Serviços</span>
              </a>

              <ul class="menu-content">
                  @shield('calendar.index')
                  <li class="{{(app('router')->is("calendar.index"))? "active": ""}}">
                      <a href="{{route("calendar.index")}}">
                          <i class="bx bx-calendar"></i>
                          <span class="menu-item">Calendário</span>
                      </a>
                  </li>
                  @endshield
                  @shield('occurrence.create')
                  <li class="{{(app('router')->is("occurrences.create"))? "active": ""}}">
                      <a href="{{route("occurrences.create")}}">
                          <i class="bx bx-right-arrow-alt"></i>
                          <span class="menu-item">Nova OS</span>
                      </a>
                  </li>
                  @endshield
                  @shield('occurrence.index')
                  <li class="{{(app('router')->is("occurrences.index"))? "active": ""}}" data-toggle="tooltip" title="Lista todas as Ocorrências">
                      <a href="{{route("occurrences.index")}}">
                          <i class="bx bx-right-arrow-alt"></i>
                          <span class="menu-item">Todos</span>
                      </a>
                  </li>
                  @endshield
                  @shield('occurrences.unassigned')
                  <li class="{{(app('router')->is("admin.occurrences.unassigned"))? "active": ""}}" data-toggle="tooltip" title="Lista as Ocorrências de hoje e futuras que foram importadas mas ainda não atribuídas a algum técnico">
                      <a href="{{route("admin.occurrences.unassigned")}}">
                          <i class="bx bx-right-arrow-alt"></i>
                          <span class="menu-item">Não atribuídas</span>
                      </a>
                  </li>
                  @endshield
                  @shield('occurrences.pending')
                  <li class="{{(app('router')->is("admin.occurrences.pending"))? "active": ""}}" data-toggle="tooltip" title="Lista as Ocorrências pendentes do dia e futuras que foram associadas ao técnico, porém ainda não foram executadas">
                      <a href="{{route("admin.occurrences.pending")}}">
                          <i class="bx bx-right-arrow-alt"></i>
                          <span class="menu-item">Pendentes</span>
                      </a>
                  </li>
                  @endshield
                  @shield('occurrences.closed')
                  <li class="{{(app('router')->is("admin.occurrences.closed"))? "active": ""}}" data-toggle="tooltip" title="Lista todas as Ocorrências realizadas">
                      <a href="{{route("admin.occurrences.closed")}}">
                          <i class="bx bx-right-arrow-alt"></i>
                          <span class="menu-item">Realizados</span>
                      </a>
                  </li>
                  @endshield
                  @shield('occurrences.closed_unsolved')
                  <li class="{{(app('router')->is("admin.occurrences.closed_unsolved"))? "active": ""}}" data-toggle="tooltip" title="Lista todas as Ocorrências Canceladas/Não realizadas">
                      <a href="{{route("admin.occurrences.closed_unsolved")}}">
                          <i class="bx bx-right-arrow-alt"></i>
                          <span class="menu-item">Não realizados</span>
                      </a>
                  </li>
                  @endshield
                  @shield('occurrences.pending')
                  <li class="{{(app('router')->is("admin.occurrences.not_executed"))? "active": ""}}" data-toggle="tooltip" title="Lista as Ocorrências do dia anterior e passadas que não foram executadas">
                      <a href="{{route("admin.occurrences.not_executed")}}">
                          <i class="bx bx-right-arrow-alt"></i>
                          <span class="menu-item">Não executadas</span>
                      </a>
                  </li>
                  @endshield
                  @shield('occurrences.pending')
                  <li class="{{(app('router')->is("admin.occurrences.status_schedule"))? "active": ""}}" data-toggle="tooltip" title="Lista as Ocorrências que necessitam de reagendamento">
                      <a href="{{route("admin.occurrences.status_schedule")}}">
                          <i class="bx bx-right-arrow-alt"></i>
                          <span class="menu-item">Reagendar</span>
                      </a>
                  </li>
                  @endshield
              </ul>
          </li>
          @endif --}}

          {{-- @if(!Defender::is('cliente'))
          <li class="nav-item
            @if(
                app('router')->is("admin.occurrences.to_approved")
                OR app('router')->is("admin.occurrences.approved")
                OR app('router')->is("admin.occurrences.to_adjust")
                OR app('router')->is("admin.occurrences.adjusted")
                OR app('router')->is("admin.occurrences.disapproved")
                OR app('router')->is("financials*")
            ) {{"active"}} @endif ">
              <a href="#">
                  <i class="menu-livicon" data-icon="coins"></i>
                  <span class="menu-title">Conclusão</span>
              </a>

              <ul class="menu-content">
                  @shield('financial.dashboard')
                  <li class="{{(app('router')->is("financials.dashboard"))? "active": ""}}" data-toggle="tooltip" title="Monitoramento administrativo">
                      <a href="{{route("financials.dashboard")}}">
                          <i class="bx bx-right-arrow-alt"></i>
                          <span class="menu-item">Monitoramento</span>
                      </a>
                  </li>
                  @endshield
                  @shield('occurrences.to_approved')
                  <li class="{{(app('router')->is("admin.occurrences.to_approved"))? "active": ""}}" data-toggle="tooltip" title="Lista as Ocorrências finalizadas que estão pendentes da aprovação administrativa">
                      <a href="{{route("admin.occurrences.to_approved")}}">
                          <i class="bx bx-right-arrow-alt"></i>
                          <span class="menu-item">Pendente de aprovação</span>
                      </a>
                  </li>
                  @endshield
                  @shield('occurrences.approved')
                  <li class="{{(app('router')->is("admin.occurrences.approved"))? "active": ""}}" data-toggle="tooltip" title="Lista as Ocorrências finalizadas que já estão aprovadas pelo administrativo">
                      <a href="{{route("admin.occurrences.approved")}}">
                          <i class="bx bx-right-arrow-alt"></i>
                          <span class="menu-item">Aprovado pelo administrativo</span>
                      </a>
                  </li>
                  @endshield
                  @shield('occurrences.to_adjust')
                  <li class="{{(app('router')->is("admin.occurrences.to_adjust"))? "active": ""}}" data-toggle="tooltip" title="Lista as Ocorrências que foram solicitado ajustes">
                      <a href="{{route("admin.occurrences.to_adjust")}}">
                          <i class="bx bx-right-arrow-alt"></i>
                          <span class="menu-item">Para Empresa ajustar</span>
                      </a>
                  </li>
                  @endshield
                  @shield('occurrences.adjusted')
                  <li class="{{(app('router')->is("admin.occurrences.adjusted"))? "active": ""}}" data-toggle="tooltip" title="Lista as Ocorrências que foram ajustadas pela Empresa">
                      <a href="{{route("admin.occurrences.adjusted")}}">
                          <i class="bx bx-right-arrow-alt"></i>
                          <span class="menu-item">Ajustado pela Empresa</span>
                      </a>
                  </li>
                  @endshield
                  @shield('occurrences.disapproved')
                  <li class="{{(app('router')->is("admin.occurrences.disapproved"))? "active": ""}}" data-toggle="tooltip" title="Lista as Ocorrências que foram rejeitadas pelo administrativo">
                      <a href="{{route("admin.occurrences.disapproved")}}">
                          <i class="bx bx-right-arrow-alt"></i>
                          <span class="menu-item">Reprovadas</span>
                      </a>
                  </li>
                  @endshield
                  @shield('financial.index')
                  <li class="{{(app('router')->is("financials.index"))? "active": ""}}">
                      <a href="{{route("financials.index")}}">
                          <i class="bx bx-right-arrow-alt"></i>
                          <span class="menu-item">Interações</span>
                      </a>
                  </li>
                  @endshield
              </ul>
          </li>
          @endif --}}

          {{-- @shield('occurrence_clients.index')
          <li class="nav-item {{(app('router')->is("occurrence_clients*"))? "active": ""}}">
              <a href="{{route("occurrence_clients.index")}}">
                  <i class="menu-livicon" data-icon="user"></i>
                  <span class="menu-title">Clientes</span>
              </a>
          </li>
          @endshield
          @if(!Defender::is('cliente'))
          <li class="nav-item
            @if(
                app('router')->is("interference*")
                )
          {{"active"}}
          @endif ">
              <a href="#">
                  <i class="menu-livicon" data-icon="briefcase"></i>
                  <span class="menu-title">Interferências</span>
              </a>
              <ul class="menu-content">

                  @shield('interference.relatorio')
                  <li class="{{(app('router')->is("interferences.dashboard"))? "active": ""}}">
                      <a href="{{route("interferences.dashboard")}}">
                          <i class="bx bx-right-arrow-alt"></i>
                          <span class="menu-item">Dashboard</span>
                      </a>
                  </li>
                  @endshield

                  @shield('interference.relatorio')
                  <li class="{{(app('router')->is("interferences.clients"))? "active": ""}}">
                      <a href="{{route("interferences.clients")}}">
                          <i class="bx bx-right-arrow-alt"></i>
                          <span class="menu-item">Relatório por clientes</span>
                      </a>
                  </li>
                  @endshield

                  @shield('interference.index')
                  <li class="{{(app('router')->is("interferences.index"))? "active": ""}}">
                      <a href="{{route("interferences.index")}}">
                          <i class="bx bx-right-arrow-alt"></i>
                          <span class="menu-item">Cadastros</span>
                      </a>
                  </li>
                  @endshield
              </ul>
          </li>
          @endif
          @if(
            \Artesaos\Defender\Facades\Defender::hasPermission('importOs.index') ||
            \Artesaos\Defender\Facades\Defender::hasPermission('log_imports.index') ||
            \Artesaos\Defender\Facades\Defender::hasPermission('log_import_errors.index') ||
           \Artesaos\Defender\Facades\Defender::hasRole('regiao')
            )

              <li class="nav-item
                @if(
                    app('router')->is("importOs*")
                    OR app('router')->is("log_imports*")
                    OR app('router')->is("log_import_errors*")
                ) {{"active"}} @endif ">
                  <a href="#">
                      <i class="menu-livicon" data-icon="upload"></i>
                      <span class="menu-title">Importação</span>
                  </a>

                  <ul class="menu-content">
                      @shield('importOs.index')
                      <li class="{{(app('router')->is("importOs.index"))? "active": ""}}">
                          <a href="{{route("importOs.index")}}">
                              <i class="bx bx-right-arrow-alt"></i>
                              <span class="menu-item">Importar OS</span>
                          </a>
                      </li>
                      @endshield
                      @shield('log_imports.index')
                      <li class="{{(app('router')->is("log_imports*"))? "active": ""}}">
                          <a href="{{route("log_imports.index")}}">
                              <i class="bx bx-right-arrow-alt"></i>
                              <span class="menu-item">Logs de Importação</span>
                          </a>
                      </li>
                      @endshield
                      @shield('log_import_errors.index')
                      <li class="{{(app('router')->is("log_import_errors*"))? "active": ""}}">
                          <a href="{{route("log_import_errors.index")}}">
                              <i class="bx bx-right-arrow-alt"></i>
                              <span class="menu-item">Logs de erros</span>
                          </a>
                      </li>
                      @endshield
                  </ul>
              </li>

          @endif

          @shield('export.index')
          <li class="nav-item {{(app('router')->is("export*"))? "active": ""}}">
              <a href="{{route("export.index")}}">
                  <i class="menu-livicon" data-icon="download"></i>
                  <span class="menu-title">Exportação de OS</span>
              </a>
          </li>
          @endshield
          @if(!Defender::is('cliente'))
          <li class="nav-item
            @if(
                app('router')->is("users*")
                OR app('router')->is("group_user*")
                OR app('router')->is("teams*")
                OR app('router')->is("operators*")
                OR app('router')->is("operator*")
            ) {{"active"}} @endif ">
              <a href="#">
                  <i class="menu-livicon" data-icon="users"></i>
                  <span class="menu-title">Usuários</span>
              </a>

              <ul class="menu-content">
                  @shield('users.index')
                  <li class="{{(app('router')->is("users*"))? "active": ""}}">
                      <a href="{{route("users.index")}}">
                          <i class="bx bx-right-arrow-alt"></i>
                          <span class="menu-item">Usuários Web</span>
                      </a>
                  </li>
                  @endshield
                  @shield('group-user')
                  <li class="{{(app('router')->is("group_user*"))? "active": ""}}">
                      <a href="{{route("group_user.index")}}">
                          <i class="bx bx-right-arrow-alt"></i>
                          <span class="menu-item">Grupos de usuário</span>
                      </a>
                  </li>
                  @endshield
                  @shield('team.index')
                  <li class="{{(app('router')->is("teams*"))? "active": ""}}">
                      <a href="{{route("teams.index")}}">
                          <i class="bx bx-right-arrow-alt"></i>
                          <span class="menu-item">Equipes</span>
                      </a>
                  </li>
                  @endshield
                  @shield('operator.index')
                  <li class="{{(app('router')->is("operator*"))? "active": ""}}">
                      <a href="{{route("operators.index")}}">
                          <i class="bx bx-right-arrow-alt"></i>
                          <span class="menu-item">Técnicos (Aplicativo)</span>
                      </a>
                  </li>
                  <li class="{{(app('router')->is("rh.export"))? "active": ""}}">
                      <a href="{{route("rh.export")}}">
                          <i class="bx bx-right-arrow-alt"></i>
                          <span class="menu-item">Exportação RH</span>
                      </a>
                  </li>
                  <li class="{{(app('router')->is("users.clients"))? "active": ""}}">
                      <a href="{{route("users.clients")}}">
                          <i class="bx bx-right-arrow-alt"></i>
                          <span class="menu-item">Usuários Clientes</span>
                      </a>
                  </li>
                  @endshield
              </ul>
          </li>
          @endif
          @if(
          \Artesaos\Defender\Facades\Defender::hasPermission('vehicles.index') ||
          \Artesaos\Defender\Facades\Defender::hasPermission('vehicles.checklist')
          )
              <li class="nav-item
                @if(
                    app('router')->is("vehicles*")
                ) {{"active"}} @endif ">
                  <a href="#">
                      <i class="menu-livicon" data-icon="car"></i>
                      <span class="menu-title">Veículos</span>
                  </a>

                  <ul class="menu-content">
                      @shield('vehicles.index')
                      <li class="{{(app('router')->is("vehicles.index"))? "active": ""}}">
                          <a href="{{route("vehicles.index")}}">
                              <i class="bx bx-right-arrow-alt"></i>
                              <span class="menu-item">Veículos</span>
                          </a>
                      </li>
                      @endshield
                      @shield('vehicles.checklist')
                      <li class="{{(app('router')->is("checklist_vechicle_itens.index"))? "active": ""}}">
                        <a href="{{route("checklist_vechicle_itens.index")}}">
                            <i class="bx bx-right-arrow-alt"></i>
                            <span class="menu-item">Itens do checklist</span>
                        </a>
                      </li>
                      <li class="{{(app('router')->is("vehicles.checklist"))? "active": ""}}">
                          <a href="{{route("vehicles.checklist")}}">
                              <i class="bx bx-right-arrow-alt"></i>
                              <span class="menu-item">Checklists</span>
                          </a>
                      </li>
                      @endshield
                  </ul>
              </li>
          @endif

          @shield('equipment.index')
          <li class="nav-item {{(app('router')->is("equipments*"))? "active": ""}}">
              <a href="{{route("equipments.index")}}">
                  <i class="menu-livicon" data-icon="gears"></i>
                  <span class="menu-title">Equipamentos</span>
              </a>
          </li>
          @endshield

          @shield('workday.index')
          <li class="nav-item {{(app('router')->is("workday*"))? "active": ""}}">
              <a href="{{route("workday.index")}}">
                <i class="menu-livicon" data-icon="calendar"></i>
                <span class="menu-title">Jornada de trabalho</span>
              </a>
          </li>
          @endshield

          @if(
          \Artesaos\Defender\Facades\Defender::hasPermission('product_category.index')
          )
              <li class="nav-item @if(
                app('router')->is("products*")
                OR app('router')->is("categories*")
            ) {{"active"}} @endif">
                  <a href="#">
                      <i class="menu-livicon" data-icon="box"></i>
                      <span class="menu-title">Produtos</span>
                  </a>

                  <ul class="menu-content">
                      @shield('product_category.index')
                      <li class="{{(app('router')->is("products.*"))? "active": ""}}">
                          <a href="{{route("products.index")}}">
                              <i class="bx bx-right-arrow-alt"></i>
                              <span class="menu-item">Produtos</span>
                          </a>
                      </li>
                      @endshield
                      @shield('product_category.index')
                      <li class="{{(app('router')->is("categories.*"))? "active": ""}}">
                          <a href="{{route("categories.index")}}">
                              <i class="bx bx-right-arrow-alt"></i>
                              <span class="menu-item">Categorias</span>
                          </a>
                      </li>
                      @endshield
                  </ul>
              </li>
          @endif

          @if(
            \Artesaos\Defender\Facades\Defender::hasPermission('expense_type.index')||
            \Artesaos\Defender\Facades\Defender::hasPermission('expense.index')||
            \Artesaos\Defender\Facades\Defender::hasPermission('repayment.index')
            )
                <li class="nav-item">
                    <a href="#">
                        <i class="menu-livicon" data-icon="euro"></i>
                        <span class="menu-title">Reembolso</span>
                    </a>

                    <ul class="menu-content">
                        @shield('expense_type.index')
                        <li class="{{(app('router')->is("expense_types.*"))? "active": ""}}">
                            <a href="{{route("expense_types.index")}}">
                                <i class="bx bx-right-arrow-alt"></i>
                                <span class="menu-item">Tipo de despesas</span>
                            </a>
                        </li>
                        @endshield
                        @shield('expense.index')
                        <li class="{{(app('router')->is("expense.*"))? "active": ""}}">
                            <a href="{{route("expense.index")}}">
                                <i class="bx bx-right-arrow-alt"></i>
                                <span class="menu-item">Despesas</span>
                            </a>
                        </li>
                        @endshield
                        @shield('repayment.index')
                        <li class="{{(app('router')->is("repayment.*"))? "active": ""}}">
                            <a href="{{route("repayment.index")}}">
                                <i class="bx bx-right-arrow-alt"></i>
                                <span class="menu-item">Reembolso</span>
                            </a>
                        </li>
                        @endshield
                    </ul>
                </li>
            @endif

            @shield('zone.index')
            <li class="nav-item {{(app('router')->is("zone*"))? "active": ""}}">
                <a href="{{route("zones.index")}}">
                    <i class="menu-livicon" data-icon="globe"></i>
                    <span class="menu-title">Zonas</span>
                </a>
            </li>
            @endshield


          @shield('log.index')
          <li class="nav-item {{(app('router')->is("log*"))? "active": ""}}">
              <a href="{{route("log.index")}}">
                  <i class="menu-livicon" data-icon="calendar"></i>
                  <span class="menu-title">Auditoria</span>
              </a>
          </li>
          @endshield

          @if(!Defender::is('cliente'))
          <li class="nav-item
            @if(
                app('router')->is("forms*")
                OR app('router')->is("form*")
                OR app('router')->is("documents*")
                OR app('router')->is("occurrence_types*")
                OR app('router')->is("cancelamento_statuses*")
                OR app('router')->is("skills*")


                )
          {{"active"}}
          @endif ">
              <a href="#">
                  <i class="menu-livicon" data-icon="briefcase"></i>
                  <span class="menu-title">Administrativo</span>
              </a>

              <ul class="menu-content">
                  @shield('contractor.show')
                  <li class="{{(app('router')->is("contractors.admin.show"))? "active": ""}}">
                      <a href="{{route("contractors.admin.show")}}">
                          <i class="bx bx-right-arrow-alt"></i>
                          <span class="menu-item">Configurações</span>
                      </a>
                  </li>
                  @endshield
                  @shield('occurrence_type.index')
                  <li class="{{(app('router')->is("occurrence_types*"))? "active": ""}}">
                      <a href="{{route("occurrence_types.index")}}">
                          <i class="bx bx-right-arrow-alt"></i>
                          <span class="menu-item">Tipos de Ocorrências</span>
                      </a>
                  </li>
                  @endshield
                  @shield('form.index')
                  <li class="{{(app('router')->is("forms*"))? "active": ""}}">
                      <a href="{{route("forms.index")}}">
                          <i class="bx bx-right-arrow-alt"></i>
                          <span class="menu-item">Formulários</span>
                      </a>
                  </li>
                  @endshield
                  @shield('document.index')
                  <li class="{{(app('router')->is("document*"))? "active": ""}}">
                      <a href="{{route("documents.index")}}">
                          <i class="bx bx-right-arrow-alt"></i>
                          <span class="menu-item">Documentos</span>
                      </a>
                  </li>
                  @endshield
                  @shield('cancelamento_status.index')
                  <li class="{{(app('router')->is("cancelamento_statuses*"))? "active": ""}}">
                      <a href="{{route("cancelamento_statuses.index")}}">
                          <i class="bx bx-right-arrow-alt"></i>
                          <span class="menu-item">Motivo não realizado</span>
                      </a>
                  </li>
                  @endshield
                  @shield('skill.index')
                  <li class="{{(app('router')->is("skills*"))? "active": ""}}">
                      <a href="{{route("skills.index")}}">
                          <i class="bx bx-right-arrow-alt"></i>
                          <span class="menu-item">Habilidades</span>
                      </a>
                  </li>
                  @endshield
                  @shield('plan_occurrences.index')
                  <li class="{{(app('router')->is("plan_occurrences*"))? "active": ""}}">
                      <a href="{{route("plan_occurrences.index")}}">
                          <i class="bx bx-right-arrow-alt"></i>
                          <span class="menu-item">Plano de manutenção</span>
                      </a>
                  </li>
                  @endshield
                  @shield('groups.index')
                  <li class="{{(app('router')->is("groups*"))? "active": ""}}">
                      <a href="{{route("groups.index")}}">
                          <i class="bx bx-right-arrow-alt"></i>
                          <span class="menu-item">Grupos de clientes</span>
                      </a>
                  </li>
                  @endshield
              </ul>
          </li>
          @endif
          <li class="{{(app('router')->is("app_versions*"))? "active": ""}}">
            <a href="{{route("app_versions.index")}}">
                <i class="menu-livicon" data-icon="morph-orientation-smartphone"></i>
                <span class="menu-item">Aplicativo</span>
            </a>
          {{-- </li> --}}

          {{-- @is('superuser')
          <li class="nav-item
            @if(
                app('router')->is("configurations*")
                OR app('router')->is("contractor_occurrence_types*")
                OR app('router')->is("permissions*")
                OR app('router')->is("roles*")
                OR app('router')->is("forms*")
                OR app('router')->is("form_groups*")
                OR app('router')->is("form_sections*")
                OR app('router')->is("form_sections_user")
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
          @endif ">
              <a href="#">
                  <i class="menu-livicon" data-icon="lock"></i>
                  <span class="menu-title">Bio-Manguinhos</span>
              </a>

              <ul class="menu-content">                
                  @shield('contractor.index')
                  <li class="{{(app('router')->is("contractors*"))? "active": ""}}">
                      <a href="{{route("contractors.index")}}">
                          <i class="bx bx-right-arrow-alt"></i>
                          <span class="menu-item">Empresas</span>
                      </a>
                  </li>
                  @endshield
                  @shield('team.index')
                  <li class="{{(app('router')->is("teams*"))? "active": ""}}">
                      <a href="{{route("teams.index")}}">
                          <i class="bx bx-right-arrow-alt"></i>
                          <span class="menu-item">Setores</span>
                      </a>
                  </li>
                  @endshield
                  @shield('contractor_occurrence_type.index')
                  <li class="{{(app('router')->is("contractor_occurrence_types*"))? "active": ""}}">
                      <a href="{{route("contractor_occurrence_types.index")}}">
                          <i class="bx bx-right-arrow-alt"></i>
                          <span class="menu-item">Empresas x Occorrências</span>
                      </a>
                  </li>
                  @endshield
                  @shield('district.index')
                  <li class="{{(app('router')->is("districts*"))? "active": ""}}">
                      <a href="{{route("districts.index")}}">
                          <i class="bx bx-right-arrow-alt"></i>
                          <span class="menu-item">Bairros</span>
                      </a>
                  </li>
                  @endshield
                  @shield('contractor_district.index')
                  <li class="{{(app('router')->is("contractor_districts*"))? "active": ""}}">
                      <a href="{{route("contractor_districts.index")}}">
                          <i class="bx bx-right-arrow-alt"></i>
                          <span class="menu-item">Empresa x Bairros</span>
                      </a>
                  </li>
                  @endshield
                  @shield('configuration.index')
                  <li class="{{(app('router')->is("configuration*"))? "active": ""}}">
                      <a href="{{route("configuration.index")}}">
                          <i class="bx bx-right-arrow-alt"></i>
                          <span class="menu-item">Configurações</span>
                      </a>
                  </li>
                  @endshield
                  @shield('general_setting.index')
                  <li class="{{(app('router')->is("general_setting*"))? "active": ""}}">
                      <a href="{{route("general_setting.index")}}">
                          <i class="bx bx-right-arrow-alt"></i>
                          <span class="menu-item">Configurações Gerais</span>
                      </a>
                  </li>
                  @endshield

                <li class="{{(app('router')->is("permissions*"))? "active": ""}}">
                    <a href="{{route("permissions.index")}}">
                        <i class="bx bx-right-arrow-alt"></i>
                        <span class="menu-item">Permissões</span>
                    </a>
                </li>
                <li class="{{(app('router')->is("roles*"))? "active": ""}}">
                    <a href="{{route("roles.index")}}">
                        <i class="bx bx-right-arrow-alt"></i>
                        <span class="menu-item">Perfil (regras)</span>
                    </a>
                </li>

                <li class="{{(app('router')->is("sms*"))? "active": ""}}">
                    <a href="{{route("sms.index")}}">
                        <i class="bx bx-right-arrow-alt"></i>
                        <span class="menu-item">SMS</span>
                    </a>
                </li>
                <li class="{{(app('router')->is("log_locals*"))? "active": ""}}">
                    <a href="{{route("log_locals.index")}}">
                        <i class="bx bx-right-arrow-alt"></i>
                        <span class="menu-item">Log Android</span>
                    </a>
                </li>

                @shield('finish_work_days.index')
                <li class="{{(app('router')->is("finish_work_days*"))? "active": ""}}">
                    <a href="{{route("finish_work_days.index")}}">
                        <i class="bx bx-right-arrow-alt"></i>
                        <span class="menu-item">Jornada do Dia</span>
                    </a>
                </li>
                @endshield

                @shield('routing.index')
                <li class="{{(app('router')->is("routing.*"))? "active": ""}}">
                <a href="{{route("routing.index")}}">
                    <i class="bx bx-right-arrow-alt"></i>
                    <span class="menu-item">Roteirização</span>
                </a>
            </li>
                @endshield


                  <li class="navigation-header"><span>Formulários</span></li>

                  @shield('form.index')
                  <li class="{{(app('router')->is("forms*"))? "active": ""}}">
                      <a href="{{route("forms.index")}}">
                          <i class="bx bx-right-arrow-alt"></i>
                          <span class="menu-item">Formulários</span>
                      </a>
                  </li>
                  @endshield
                  @shield('occurrence_type_form.index')
                  <li class="{{(app('router')->is("occurrence_type_forms*"))? "active": ""}}">
                      <a href="{{route("occurrence_type_forms.index")}}">
                          <i class="bx bx-right-arrow-alt"></i>
                          <span class="menu-item">Assoçiação de formulários</span>
                      </a>
                  </li>
                  @endshield
              </ul>
          </li>
          @endis --}}

          {{-- <li class="nav-item">
              <a href="http://suporte.centralsystem.com.br" target="_blank">
                  <i class="menu-livicon" data-icon="wrench"></i>
                  <span class="menu-title">Suporte</span>
              </a>
          </li>        --}}

          <li class="nav-item">
              <a href="{{ url('/logout') }}"
                 onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                  <i class="menu-livicon" data-icon="external-link"></i>
                  <span class="menu-title">Sair</span>
              </a>
              <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                  {{ csrf_field() }}
              </form>
          </li>
      </ul>
      </div>
  </div>
@endif
{{-- horizontal-menu --}}
@if($configData['mainLayoutType'] == 'horizontal-menu')
<div class="header-navbar navbar-expand-sm navbar navbar-horizontal navbar-light navbar-without-dd-arrow
@if($configData['navbarType'] === 'navbar-static') {{'navbar-sticky'}} @endif" role="navigation" data-menu="menu-wrapper">
  <div class="navbar-header d-xl-none d-block">
      <ul class="nav navbar-nav flex-row">
      <li class="nav-item mr-auto">
          <a class="navbar-brand" href="{{asset('/')}}">
          <div class="brand-logo">
            <img src="{{asset('images/logo/logo.png')}}" class="logo" alt="">
          </div>
          <h2 class="brand-text mb-0">
            @if(!empty($configData['templateTitle']) && isset($configData['templateTitle']))
            {{$configData['templateTitle']}}
            @else
            Bio-Manguinhos
            @endif
          </h2>
          </a>
      </li>
      <li class="nav-item nav-toggle">
          <a class="nav-link modern-nav-toggle pr-0" data-toggle="collapse">
          <i class="bx bx-x d-block d-xl-none font-medium-4 primary toggle-icon"></i>
          </a>
      </li>
      </ul>
  </div>
  <div class="shadow-bottom"></div>
  <!-- Horizontal menu content-->
  <div class="navbar-container main-menu-content" data-menu="menu-container">
      <ul class="nav navbar-nav" id="main-menu-navigation" data-menu="menu-navigation" data-icon-style="filled">
      @if(!empty($menuData[1]) && isset($menuData[1]))
          @foreach ($menuData[1]->menu as $menu)
          <li class="@if(isset($menu->submenu)){{'dropdown'}} @endif nav-item" data-menu="dropdown">
          <a class="@if(isset($menu->submenu)){{'dropdown-toggle'}} @endif nav-link" href="{{asset($menu->url)}}"
            @if(isset($menu->submenu)){{'data-toggle=dropdown'}} @endif @if(isset($menu->newTab)){{"target=_blank"}}@endif>
              <i class="menu-livicon" data-icon="{{$menu->icon}}"></i>
              <span>{{ __('locale.'.$menu->name)}}</span>
          </a>
          @if(isset($menu->submenu))
              @include('panels.sidebar-submenu',['menu'=>$menu->submenu])
          @endif
          </li>
          @endforeach
      @endif
      </ul>
  </div>
  <!-- /horizontal menu content-->
  </div>
@endif

{{-- vertical-box-menu --}}
@if($configData['mainLayoutType'] == 'vertical-menu-boxicons')
<div class="main-menu menu-fixed @if($configData['theme'] === 'light') {{"menu-light"}} @else {{'menu-dark'}} @endif menu-accordion menu-shadow" data-scroll-to-active="true">
  <div class="navbar-header">
    <ul class="nav navbar-nav flex-row">
    <li class="nav-item mr-auto">
      <a class="navbar-brand" href="{{asset('/')}}">
        <div class="brand-logo">
          <img src="{{asset('images/logo/logo.png')}}" class="logo" alt="">
        </div>
        <h2 class="brand-text mb-0">
          @if(!empty($configData['templateTitle']) && isset($configData['templateTitle']))
          {{$configData['templateTitle']}}
          @else
          Bio-Manguinhos
          @endif
        </h2>
      </a>
    </li>
    <li class="nav-item nav-toggle"><a class="nav-link modern-nav-toggle pr-0" data-toggle="collapse"><i class="bx bx-x d-block d-xl-none font-medium-4 primary toggle-icon"></i><i class="toggle-icon bx bx-disc font-medium-4 d-none d-xl-block collapse-toggle-icon primary" data-ticon="bx-disc"></i></a></li>
    </ul>
  </div>
  <div class="shadow-bottom"></div>
  <div class="main-menu-content">
    <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation" data-icon-style="">
      @if(!empty($menuData[2]) && isset($menuData[2]))
      @foreach ($menuData[2]->menu as $menu)
          @if(isset($menu->navheader))
              <li class="navigation-header"><span>{{$menu->navheader}}</span></li>
          @else
          <li class="nav-item {{(request()->is($menu->url.'*')) ? 'active' : '' }}">
            <a href="@if(isset($menu->url)){{asset($menu->url)}} @endif" @if(isset($menu->newTab)){{"target=_blank"}}@endif>
            @if(isset($menu->icon))
              <i class="{{$menu->icon}}"></i>
            @endif
            @if(isset($menu->name))
              <span class="menu-title">{{ __('locale.'.$menu->name)}}</span>
            @endif
            @if(isset($menu->tag))
              <span class="{{$menu->tagcustom}}">{{$menu->tag}}</span>
            @endif
           </a>
          @if(isset($menu->submenu))
            @include('panels.sidebar-submenu',['menu' => $menu->submenu])
          @endif
          </li>
          @endif
      @endforeach
      @endif
  </ul>
  </div>
</div>
@endif
