<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h4 class="box-title">Ordens de Serviços ({{$operator->occurrencesFilterSchedule->count()}})</h4>
                @shield('routing.index')
                <button class="btn btn-primary" id="route">Roteirizar</button>
                @endshield
            </div>
            <div class="card-content">
                <div class="card-body">
                    @if($operator->occurrencesFilterSchedule->count())
                        <div class="cs_timeline">
                            <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

                            <script type="text/javascript">
                                let data_br = new Date().toLocaleDateString();
                                google.charts.load("current", {packages: ["timeline"], 'language': 'pt-br'});
                                google.charts.setOnLoadCallback(drawChart);

                                function drawChart() {

                                    var container = document.getElementById('timeline');
                                    var chart = new google.visualization.Timeline(container);
                                    var dataTable = new google.visualization.DataTable();

                                    dataTable.addColumn({type: 'string', id: 'Data do Agendamento'});
                                    dataTable.addColumn({type: 'string', id: 'Tipo da OS'});
                                    dataTable.addColumn({type: 'date', id: 'Início'});
                                    dataTable.addColumn({type: 'date', id: 'Fim'});
                                    dataTable.addRows([
                                            @foreach($operator->occurrencesFilterSchedule as $occurrence)
                                        ['{{$occurrence->schedule_date()}}', '{{$occurrence->id}} - {{optional($occurrence->occurrence_type)->name}}', new Date({{$occurrence->dataAgendamentoFormartJS()}}), new Date({{$occurrence->dataAgendamentoFormartJSLimite()}})],
                                        @endforeach
                                    ]);

                                    var options = {
                                        // timeline: { singleColor: '#8d8' },
                                    };

                                    chart.draw(dataTable, options);
                                }
                            </script>

                            <div id="timeline" style="height: 150px;"></div>
                        </div>
                    @endif
                    <div class="table-responsive">
                        <table class="table table-condensed table-striped table-sm table-hover">
                            <thead>
                            <tr>
                                @shield('occurrences.order')
                                <td></td>
                                @endshield
                                <th>ID</th>
                                <th>Nº OS</th>
                                <th>Status</th>
                                <th>OS</th>
                                <th>Cliente</th>
                                <th>Prioridade</th>
                                <th>Início</th>
                                <th>Fim</th>
                                <th>Tempo</th>
                                <th>Agendamento</th>
                                <th>Alertas</th>
                                <th></th>
                            </tr>
                            </thead>

                            <tbody class="sortable">
                            @foreach($operator->occurrencesFilterSchedule as $occurrence)
                                <tr class="{{priority_color_id($occurrence->priority)}} {{$occurrence->operator_id}}" id="{{$occurrence->id}}" data="{{$occurrence->schedule_date}}">
                                    @shield('occurrences.order')
                                    <td><i class="bx bx-move-vertical grabbable"></i></td>
                                    @endshield
                                    <td>
                                        <a href="{{ route('occurrences.show', $occurrence->uuid) }}">{{$occurrence->id}}</a>
                                    </td>
                                    <td>{{$occurrence->numero_os}}</td>
                                    <td>{{($occurrence->getStatus())}}</td>
                                    <td>{{optional($occurrence->occurrence_type)->name}}</td>
                                    <td>{{$occurrence->occurrence_client->name}}</td>
                                    <td>{{priority_name($occurrence->priority)}}</td>
                                    <td>
                                        @if(!empty($occurrence->check_in))
                                            {{ date('d/m/Y H:i', strtotime($occurrence->check_in)) }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>
                                        @if(!empty($occurrence->check_out))
                                            {{ date('d/m/Y H:i', strtotime($occurrence->check_out)) }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>{{$occurrence->calculaTempo()}}</td>
                                    <td>{{($occurrence->dataAgendamentoFormart())}}</td>
                                    <td>
                                        <div class="d-flex">
                                            @if($occurrence->alerts()->where("type", "=", 1)->count())
                                                <span title="OS em atraso" class="badge-circle badge-circle-sm badge-circle-danger ml-1">{{$occurrence->alerts()->where("type", "=", 1)->count()}}</span>
                                            @endif
                                            @if($occurrence->alerts()->where("type", "=", 4)->count())
                                                <span title="Atendimento acima do tempo médio" class="badge-circle badge-circle-sm badge-circle-warning ml-1">{{$occurrence->alerts()->where("type", "=", 4)->count()}}</span>
                                            @endif
                                            @if($occurrence->alerts()->where("type", "=", 2)->count())
                                                <span title="OS com interferência" class="badge-circle badge-circle-sm badge-circle-secondary ml-1">{{$occurrence->alerts()->where("type", "=", 2)->count()}}</span>
                                            @endif
                                            @if($occurrence->alerts()->where("type", "=", 1)->count() == 0 && $occurrence->alerts()->where("type", "=", 4)->count() == 0 && $occurrence->alerts()->where("type", "=", 2)->count() == 0)
                                                <span class="badge badge-secondary ml-1">Sem alertas</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <a href="{{ route('occurrences.show', $occurrence->uuid) }}" class="btn btn-icon btn-sm btn-primary" data-toggle="tooltip" data-placement="left" title="Exibir"><i class="bx bx-book-open"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div><!-- /Order de servico -->
