@extends('layouts.frest_template')
@section('css')
    <!-- Select2 -->
    <link rel="stylesheet" href="/bower_components/AdminLTE/plugins/select2/select2.min.css">
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/css/pickers/daterange/daterangepicker.css')}}">
@endsection

@section('content-header')
    <div class="content-header-left col-md-10 mb-2 mt-1">
        <div class="row breadcrumbs-top">
            <div class="col-md-12">
                <h5 class="content-header-title float-left pr-1 mb-0">Relatório de Interferências</h5>
                <div class="breadcrumb-wrapper col-md-12">
                    <ol class="breadcrumb p-0 mb-0">
                        <li class="breadcrumb-item"><i class="bx bx-home-alt"></i> Home</li>
                        <li class="breadcrumb-item">Dashboard</li>
                        <li class="breadcrumb-item active">Relatório de Interferências</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    @include('messages')
    @include('error')

    {{--FILTROS INICIO--}}
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Filtro </h4>
            <a class="heading-elements-toggle">
                <i class="bx bx-dots-vertical font-medium-3"></i>
            </a>
            <div class="heading-elements">
                <ul class="list-inline mb-0">
                    <li>
                        <a data-action="collapse">
                            <i class="bx bx-chevron-down"></i>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="card-content collapse show">
            <div class="card-body">
                <form class="form form-horizontal" method="get">
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="id">ID</label>
                                    <input type="text" class="form-control" name="id"
                                           value="{{ app('request')->input('id') }}" autocomplete="off"
                                           placeholder="ID">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="client_number">N° cliente</label>
                                    <input type="text" class="form-control" name="client_number"
                                           value="{{ app('request')->input('client_number') }}" autocomplete="off"
                                           placeholder="N° cliente">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="name">Nome</label>
                                    <input type="text" class="form-control" name="name"
                                           value="{{ app('request')->input('name') }}" autocomplete="off"
                                           placeholder="Nome">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="email">E-mail</label>
                                    <input type="text" class="form-control" name="email"
                                           value="{{ app('request')->input('email') }}" autocomplete="off"
                                           placeholder="E-mail">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="cpf">CPF ou CNPJ</label>
                                    <input type="text" class="form-control" name="cpf"
                                           value="{{ app('request')->input('cpf') }}" autocomplete="off"
                                           placeholder="CPF ou CNPJ">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="address">Endereço</label>
                                    <input type="text" class="form-control" name="address"
                                           value="{{ app('request')->input('address') }}" autocomplete="off"
                                           placeholder="Endereço">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="district">Bairro</label>
                                    <input type="text" class="form-control" name="district"
                                           value="{{ app('request')->input('district') }}" autocomplete="off"
                                           placeholder="Bairro">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="city">Cidade</label>
                                    <input type="text" class="form-control" name="city"
                                           value="{{ app('request')->input('city') }}" autocomplete="off"
                                           placeholder="Cidade">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="city">Interferência</label>
                                    <select class="form-control select2" name="interference_id"
                                            data-placeholder="Interferência">
                                        <option></option>
                                        @foreach($interferences as $interference)
                                            <option
                                                value="{{$interference->id}}" {{(app('request')->input('interference_id')==$interference->id?"selected":"")}}>{{$interference->description}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="schedule_date">Data do agendamento</label>
                                    <input type="text" class="input-small daterange form-control noBackgroung"
                                           size="25" id="schedule_date" name="schedule_date"
                                           value="{{ app('request')->input('schedule_date') }}" readonly>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <br>
                                    <button type="submit" class="btn btn-primary " id="btn-external-filter">Aplicar</button>
                                    <a href="/{{Route::getCurrentRoute()->uri()}}" class="btn btn-default">Limpar</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{--FILTROS FIM--}}

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="box-title">Clientes com interferências</h3>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 table-responsive">
                                @if($occurrence_clients->count())
                                    <table class="table table-condensed table-striped table-sm table-bordered">
                                        <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Nº cliente</th>
                                            <th>Nome</th>
                                            {{--                                            <th>Telefone</th>--}}
                                            <th>Bairro</th>
                                            <th>Município</th>
                                            <th class="text-right">OPÇÕES</th>
                                        </tr>
                                        </thead>

                                        <tbody>
                                        @foreach($occurrence_clients as $occurrence_client)
                                            <tr>
                                                <td>{{$occurrence_client->id}}</td>
                                                <td>{{$occurrence_client->client_number}}</td>
                                                <td><strong>{{$occurrence_client->name}}</strong></td>
                                                {{--                                                <td>{{!empty($occurrence_client->occurrence_client_phones->last()->phone)? $occurrence_client->occurrence_client_phones->last()->phone : "-"}}</td>--}}
                                                <td>{{$occurrence_client->district}}</td>
                                                <td>{{$occurrence_client->city}}</td>

                                                <td class="text-right">
                                                    @shield('occurrence_clients.show')
                                                    <a href="{{ route('occurrence_clients.show', $occurrence_client->uuid) }}" class="btn btn-icon btn-sm btn-primary" data-toggle="tooltip" title="Exibir cliente" target="_blank"><i class="bx bx-book-open"></i></a>
                                                    @endshield
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="6">
                                                    @if($occurrence_client->occurrences()->whereHas('interferences')->count())
                                                        <div class="col-md-12 table-responsive">
                                                            <table class="table table-condensed table-striped table-sm table-bordered">
                                                                <thead>
                                                                <tr>
                                                                    <th>ID</th>
                                                                    <th>Nº OS</th>
                                                                    @is('superuser','regiao')
                                                                    <th>Empreiteira</th>
                                                                    @endis
                                                                    <th>Descrição</th>
                                                                    <th>Operador</th>
                                                                    <th>Data de agendamento</th>
                                                                    <th>Interferências</th>
                                                                    <th class="text-right">OPÇÕES</th>

                                                                </tr>
                                                                </thead>

                                                                <tbody>
                                                                @foreach(
                                                                    $occurrence_client->occurrences()->whereHas('interferences', function($query) {
                                                                        $interference = Request::get('interference_id');
                                                                        if(isset($interference) && !empty($interference)){
                                                                            $query->where('interferences.id', '=', $interference);
                                                                        }
                                                                        if($interference != 1){
                                                                            $query->where('interferences.id', '<>', 1); //Sem interferências
                                                                        }
                                                                    })
                                                                    ->orderBy('occurrences.id','desc')
                                                                    ->get()
                                                                        as $occurrence)
                                                                    <tr class="table-bordered">
                                                                        <td title="OS {{ $occurrence->id }}"><span class="badge">{{ $occurrence->id }}</span></td>
                                                                        <td>{{ $occurrence->numero_os }}</td>
                                                                        @is('superuser','regiao')
                                                                        <td>{{optional($occurrence->contractor)->name}}</td>
                                                                        @endis
                                                                        <td>{{optional($occurrence->occurrence_type)->name}}</td>
                                                                        @if(!empty($occurrence->operator_id))
                                                                            <td>{!! ($occurrence->operator->status != 1)? "<strike>" : "" !!}{{(empty($occurrence->operator_id)? "" : $occurrence->operator->name)}}{!! ($occurrence->operator->status != 1)? "</strike>" : "" !!}</td>
                                                                        @else
                                                                            <td>-</td>
                                                                        @endif
                                                                        <td>{{$occurrence->dataAgendamentoFormart()}}</td>
                                                                        <td>
                                                                            @foreach($occurrence->interferences as $interference)
                                                                                <span class="badge badge-pill badge-primary" style="margin: 2px;">{{ $interference->description }}</span>
                                                                            @endforeach
                                                                        </td>
                                                                        <td class="text-right">
                                                                            @shield('occurrence.show')
                                                                            <a href="{{ route('occurrences.show', $occurrence->uuid) }}" class="btn btn-icon btn-sm btn-success" data-toggle="tooltip" title="Exibir OS {{ $occurrence->id }}" target="_blank"><i class="bx bx-book-open"></i></a>
                                                                            @endshield
                                                                        </td>
                                                                    </tr>
                                                                    @if($occurrence->obs_os)
                                                                        <tr>
                                                                            <td colspan="8">
                                                                                <div class="col-12">
                                                                                    <div class="form-group">
                                                                                        <label>Observações gerais</label>
                                                                                        <p class="form-control-static">{!! nl2br($occurrence->obs_os) !!}</p>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                    @endif
                                                                @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                    {!! $occurrence_clients->render() !!}
                                @else
                                    <h3 class="text-center alert alert-info">Vazio!</h3>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')

    <!-- Select2 -->
    <script src="/bower_components/AdminLTE/plugins/select2/select2.full.min.js"></script>
    <script src="{{asset('vendors/js/pickers/daterange/moment.min.js')}}"></script>
    <script src="{{asset('vendors/js/pickers/daterange/daterangepicker.js')}}"></script>
    <script>
        $(function () {
            //Initialize Select2 Elements
            $(".select2").select2({
                allowClear: true,
                width: "100%"
            });

            $('.daterange').daterangepicker({
                autoApply: false,
                autoUpdateInput: false,
//                maxDate: moment(),
                locale: {
                    format: 'DD/MM/YYYY',
                    cancelLabel: 'Limpar',
                    applyLabel: "Ok",
                    fromLabel: "De",
                    toLabel: "Até",
                    daysOfWeek: [
                        "D",
                        "S",
                        "T",
                        "Q",
                        "Q",
                        "S",
                        "S"
                    ],
                    monthNames: [
                        "Janeiro",
                        "Fevereiro",
                        "Março",
                        "Abril",
                        "Maio",
                        "Junho",
                        "Julho",
                        "Agosto",
                        "Setembro",
                        "Outubro",
                        "Novembro",
                        "Dezembro"
                    ],
                },
            });

            $('.daterange').on('apply.daterangepicker', function (ev, picker) {
                $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
            });
            $('.daterange').on('cancel.daterangepicker', function (ev, picker) {
                $(this).val('');
            });
        });
    </script>
@endsection
