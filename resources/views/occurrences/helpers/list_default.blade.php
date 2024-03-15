<div class="card-content">
    <div class="card-body">
        @if($occurrences->count())
            <div class="table-responsive">
                <table class="table table-condensed table-striped table-sm">
                    <thead>
                    <tr>
                        <th>ID</th>
                        {{--                        <th>Nº OS</th>--}}
                        <th>Status</th>
                        <th>OS</th>
                        <th>Cliente</th>
                        @is('superuser','regiao')
                        <th>Empreiteira</th>
                        @endis
                        <th>Bairro</th>
                        <th>Município</th>
                        <th>Operador</th>
                        <th>Agendamento</th>
                        <th>Tempo</th>
                        <th class="text-right">OPÇÕES</th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach($occurrences as $occurrence)
                        <tr>
                            <td>{{$occurrence->id}}</td>
                            {{--                            <td>{{$occurrence->numero_os}}</td>--}}
                            <td>{{$occurrence->getStatus()}}</td>
                            <td>{{optional($occurrence->occurrence_type)->name}}</td>
                            @if($occurrence->occurrence_client)
                                <td>
                                    <a href="{{route("occurrence_clients.show",optional($occurrence->occurrence_client)->uuid)}}">{{optional($occurrence->occurrence_client)->client_number}} - {{optional($occurrence->occurrence_client)->name}}</a>
                                </td>
                            @else
                                <td></td>
                            @endif
                            @is('superuser','regiao')
                            <td>{{optional($occurrence->contractor)->name}}</td>
                            @endis
                            <td>{{optional($occurrence->occurrence_client)->district}}</td>
                            <td>{{optional($occurrence->occurrence_client)->city}}</td>
                            @if($occurrence->operator)
                                <td>{!! ($occurrence->operator->status != 1)? "<strike>" : "" !!}{{(empty($occurrence->operator_id)? "" : $occurrence->operator->name)}}{!! ($occurrence->operator->status != 1)? "</strike>" : "" !!}</td>
                            @else
                                <td>-</td>
                            @endif
                            <td>{{$occurrence->dataAgendamentoFormart()}}</td>
                            <td>{{$occurrence->calculaTempo()}}</td>
                            <td style="padding: 1.15rem 0 !important;">
                                @include('occurrences.includes.options')
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            {!! $occurrences->render() !!}
        @else
            <h3 class="text-center alert alert-info">Vazio!</h3>
        @endif
    </div>
</div>
