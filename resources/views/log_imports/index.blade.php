@extends('layouts.frest_template')
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/pickers/daterange/daterangepicker.css')}}">
<!-- Select2 -->
<link rel="stylesheet" href="/bower_components/AdminLTE/plugins/select2/select2.min.css">
@section('content-header')
    <div class="content-header-left col-12 mb-2 mt-1">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h5 class="content-header-title float-left pr-1 mb-0">Logs de importação</h5>
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb p-0 mb-0">
                        <li class="breadcrumb-item"><i class="bx bx-home-alt"></i> Home</li>
                        <li class="breadcrumb-item">Importação</li>
                        <li class="breadcrumb-item active">Logs de importação</li>
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
        <div class="card-content collapse {{ app('request')->exists('name') == false ? "" : "show"}}">
            <div class="card-body">
                <form class="form form-horizontal" method="get">
                    <div class="form-body">
                        <div class="row">
                            <div class="col-2">
                                <div class="form-group">
                                    <label for="id">ID</label>
                                    <input type="text" class="form-control" name="id"
                                           value="{{ app('request')->input('id') }}" autocomplete="off"
                                           placeholder="ID">
                                </div>
                            </div>
                            @is(['regiao','superuser'])
                            <div class="col-3">
                                <div class="form-group">
                                    <label for="client_number">Empreiteiras</label>
                                    <select class="form-control select2" name="contractor_id" data-placeholder="Selecione a Empreiteira">
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
                                    <label for="name">Usuário</label>
                                    <select class="form-control select2" name="user_id" data-placeholder="Selecione um usuário">
                                        <option></option>
                                        @forelse($users as $user)
                                            <option value="{{$user->id}}" {{(app('request')->input('user_id')==$user->id?"selected":"")}}>{{$user->name}}</option>
                                        @empty
                                        @endforelse
                                    </select>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="email">Período</label>
                                    <input type="text" autocomplete="off" class="input-small daterange form-control noBackgroung" size="25" id="periodo" name="periodo" value="{{ app('request')->input('periodo') }}" readonly>
                                </div>
                            </div>
                            <div class="col-12">
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
        <div class="col-12">
            @if($log_imports->count())
                <div class="card">
                    <div class="card-header">
                        <h3 class="box-title">Erros de importação</h3>
                    </div>
                    <div class="card-content">
                        <div class="card-body table-responsive">
                            <table class="table table-condensed table-striped table-sm table-hover">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Usuário</th>
                                    <th>Nome do arquivo</th>
                                    <th>Qdt Erros</th>
                                    <th>Qdt Oks</th>
                                    <th>Qdt Total</th>
                                    <th>Enviado em</th>

                                    <th class="text-right">Opções</th>
                                </tr>
                                </thead>

                                <tbody>
                                @foreach($log_imports as $log_import)
                                    <tr>
                                        <td>{{$log_import->id}}</td>
                                        <td>{{optional($log_import->user)->name}}</td>
                                        <td>{{$log_import->original_name}}</td>
                                        <td>{{$log_import->qtd_error}}</td>
                                        <td>{{$log_import->qtd_success}}</td>
                                        <td>{{$log_import->lines}}</td>
                                        <td>{{ date('d/m/Y H:i:s', strtotime($log_import->created_at)) }}</td>

                                        <td class="text-right">
                                            @shield('log_imports.log')
                                            <a href="{{ $log_import->url }}" class="btn btn-icon btn-sm btn-info" data-toggle="tooltip" title="Download" target="_blank"><i class="bx bx-download"></i></a>
                                            @endshield
                                            @shield('log_imports.show')
                                            <a href="{{ route('log_imports.show', $log_import->uuid) }}" class="btn btn-icon btn-sm btn-primary" data-toggle="tooltip" data-placement="left" title="Exibir"><i class="bx bx-book-open"></i></a>
                                            @endshield
                                            @shield('log_imports.edit')
                                            <a href="{{ route('log_imports.edit', $log_import->uuid) }}" class="btn btn-icon btn-sm btn-warning" data-toggle="tooltip" data-placement="left" title="Editar"><i class="bx bx-pencil"></i></a>
                                            @endshield
                                            @shield('log_imports.destroy')
                                            <form action="{{ route('log_imports.destroy', $log_import->uuid) }}"
                                                  method="POST" style="display: inline;"
                                                  onsubmit="if(confirm('Deseja deletar esse item?')) { return true } else {return false };">
                                                <input type="hidden" name="_method" value="DELETE">
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                <button type="submit" class="btn btn-icon btn-sm btn-danger" data-toggle="tooltip" data-placement="left" title="Deletar"><i class="bx bx-trash"></i></button>
                                            </form>
                                            @endshield
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            {!! $log_imports->render() !!}
                        </div>
                    </div>
                </div>
            @else
                <h3 class="text-center alert alert-info">Vazio!</h3>
            @endif
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
