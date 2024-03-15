@extends('layouts.frest_template')
@section('css')
    <!-- DataTables -->
    <link rel="stylesheet" href="/js/datatables/dataTables.bootstrap.css">
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/css/pickers/daterange/daterangepicker.css')}}">
    <link rel="stylesheet" href="/bower_components/AdminLTE/plugins/select2/select2.min.css">
@endsection
@section('header')
    <div class="page-header clearfix">
        <h2>
            Exportação para Recursos Humanos ({{$moves->total()}})

        </h2>
    </div>
@endsection

@section('content-header')
    <div class="content-header-left col-10 mb-2 mt-1">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h5 class="content-header-title float-left pr-1 mb-0">Exportação para Recursos Humanos</h5>
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb p-0 mb-0">
                        <li class="breadcrumb-item"><i class="bx bx-home-alt"></i> Home</li>
                        <li class="breadcrumb-item">Usuários</li>
                        <li class="breadcrumb-item active">Exportação para Recursos Humanos</li>
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
                            @is(['regiao','superuser'])
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="contractor">Empreiteiras</label>
                                    <select class="form-control select2" name="contractor_id" data-placeholder="Selecione o tipo da Ocorrência">
                                        <option></option>
                                        @forelse($contractors as $contractor)
                                            <option value="{{$contractor->id}}" {{(app('request')->input('contractor_id')==$contractor->id?"selected":"")}}>{{$contractor->name}}</option>
                                        @empty
                                        @endforelse
                                    </select>
                                </div>
                            </div>
                            @endis
                            <div class="col-3">
                                <div class="form-group">
                                    <label for="contractor">Período</label>
                                    <input type="text" autocomplete="off" class="input-small daterange form-control noBackgroung" size="25" id="periodo" name="periodo" value="{{ app('request')->input('periodo') }}" readonly>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="move_type_id">Tipo</label>
                                    <select class="form-control select2" id="move_type_id" name="move_type_id" data-placeholder="Técnico">
                                        <option></option>
                                        @forelse($move_types as $move_type)
                                            <option value="{{$move_type->id}}" {{((app('request')->input('move_type_id')==$move_type->id) ? "selected":"")}}>
                                                {{$move_type->name}}
                                            </option>
                                        @empty
                                        @endforelse
                                    </select>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="operator_id">Técnico</label>
                                    <select class="form-control select2" id="operator_id" name="operator_id" data-placeholder="Técnico">
                                        <option></option>
                                        @forelse($operators as $operator)
                                            <option value="{{$operator->id}}" {{((app('request')->input('operator_id')==$operator->id) ? "selected":"")}}>
                                                {{$operator->id}} - {{$operator->name}}
                                            </option>
                                        @empty
                                        @endforelse
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <button type="submit" class="btn btn-success " id="btn-external-filter" name="export" value="export"><i class="bx bx-download"></i> Exportar em Excel</button>
                                <button type="submit" class="btn btn-success " id="btn-external-filter" name="export" value="exportPdf"><i class="bx bx-download"></i> Exportar em PDF</button>
                            </div>
                            <div class="col-6 d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary " id="btn-external-filter">Aplicar</button>
                                <a href="/{{Route::getCurrentRoute()->uri()}}" class="btn btn-link pull-right"><i class="bx bx-eraser"></i> Limpar</a>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
    {{--FILTROS FIM--}}

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="box-title">Exportação para Recursos Humanos ({{$moves->total()}})</h3>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        @if($moves->count())
                            <div class="table-responsive">
                                <table class="table table-condensed table-striped table-sm table-hover">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nome</th>
                                        <th>Empresa</th>
                                        <th>Tipo</th>
                                        <th>Data/hora</th>
                                        {{--                            <th class="text-right">OPÇÕES</th>--}}
                                    </tr>
                                    </thead>

                                    <tbody>
                                    @foreach($moves as $move)
                                        <tr>
                                            <td>{{$move->operator->id}}</td>
                                            <td>
                                                <a class="" href="{{ route('operators.show', $move->operator->uuid) }}">
                                                    {!! ($move->operator->status != 1)? "<strike>" : "" !!}
                                                    {{ strtoupper($move->operator->name)}}{!! ($move->operator->status != 1)? "<strike>" : "" !!}
                                                </a>
                                            </td>
                                            <td>{{$move->operator->contractor->name}}</td>
                                            <td>{{$move->move_type->name}}</td>
                                            <td>{{$move->dateCheckin()}}</td>
                                        </tr>

                                    @endforeach

                                    </tbody>
                                </table>
                            </div>
                            {!! $moves->render() !!}

                        @else
                            <h3 class="text-center alert alert-info">Vazio!</h3>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('scripts')
    <!-- Select2 -->
    <script src="{{asset('vendors/js/pickers/daterange/moment.min.js')}}"></script>
    <script src="{{asset('vendors/js/pickers/daterange/daterangepicker.js')}}"></script>
    <script src="/bower_components/AdminLTE/plugins/select2/select2.full.min.js"></script>
    <script nonce="{{ csp_nonce() }}">
        $(function () {
            //Initialize Select2 Elements
            $(".select2").select2({
                allowClear: true,
                width: "100%"
            });
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
    </script>
@endsection
