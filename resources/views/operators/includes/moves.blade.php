@if(count($moves))
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="box-title">Movimentação</h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="foto">Serviço iniciado no dia</label>
                                    <p class="form-control-static" >@if($attendece_first){{ date('d/m/Y H:i:s', strtotime($attendece_first->check_in)) }}@endif</p>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="foto">Serviço finalizado no dia</label>
                                    <p class="form-control-static" >@if($attendece_last){{ date('d/m/Y H:i:s', strtotime($attendece_last->check_out)) }}@endif</p>
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-condensed table-striped table-sm table-hover">
                                <thead>
                                <tr>
                                    <th>Tipo Movimentação</th>
                                    <th>OS</th>
                                    <th>Data Agendamento</th>
                                    <th>Tempo Decorrido</th>
                                    <th>Mapa Checkin</th>
                                    <th title="Data que a ação foi realizada no celular">Data Celular</th>
                                    <th title="Data que o sistema recebeu a informação">Data Sistema</th>
                                </tr>
                                </thead>

                                <tbody>
                                @foreach($moves as $move)
                                    <tr>
                                        <td>{{$move->move_type->name}}</td>
                                        <td>
                                            @if($move->occurrence)
                                                <a href="{{ route('occurrences.show', $move->occurrence->uuid) }}">{!! $move->occurrence->id !!}</a>
                                            @endif
                                        </td>
                                        <td>
                                            @if($move->occurrence)
                                                {{$move->occurrence->dataAgendamentoFormart()}}
                                            @endif
                                        </td>
                                        <td>
                                            @if ($move->move_type_id == 5)
                                                {{tmpDeslocamento($move->occurrence, 4, 5)}}
                                            @elseif ($move->move_type_id == 7)
                                                {{tmpDeslocamento($move->occurrence, 6, 7)}}
                                            @else
                                                ---
                                            @endif

                                        </td>
                                        <td>
                                            <a href="https://www.google.com/maps/?q={{$move->check_in_lat}},{{$move->check_in_long}}"
                                               class="btn btn-info btn-xs" target="_blank"><i class="bx bx-share"></i>Ver no
                                                Maps</a>
                                        </td>
                                        <td>{{$move->dateCheckin()}}</td>
                                        <td>{{$move->dateCreated()}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Movimentacao -->
@endif
