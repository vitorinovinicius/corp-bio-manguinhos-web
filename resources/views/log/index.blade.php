@extends('layouts.frest_template')
@section('css')
    <!-- Select2 -->
    <link rel="stylesheet" href="/bower_components/AdminLTE/plugins/select2/select2.min.css">
    <!-- daterange picker -->
    <link rel="stylesheet" href="/bower_components/AdminLTE/plugins/daterangepicker/daterangepicker.css">
    <style nonce="{{ csp_nonce() }}">
        .my-custom-scrollbar {
            position: relative;
            height: 180px;
            overflow: auto;
        }
        .table-wrapper-scroll-y {
            display: block;
        }
    </style>
@endsection
@section('content-header')
    <div class="content-header-left col-12 mb-2 mt-1">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h5 class="content-header-title float-left pr-1 mb-0">Auditoria</h5>
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb p-0 mb-0">
                        <li class="breadcrumb-item"><i class="bx bx-home-alt"></i> Home</li>
                        <li class="breadcrumb-item active">Auditoria</li>
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
    <div class="row">
        <div class="col-12">
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
                        <form class="form form-vertical" method="GET">
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label>Usuário</label>
                                            <select class="form-control select2" name="user_id" data-placeholder="Selecione um usuário">
                                                <option></option>
                                                @forelse($users as $user)
                                                    <option value="{{$user->id}}" {{(isset($_GET["user_id"]) && !empty($_GET["user_id"]) && $_GET["user_id"] == $user->id) ? "selected" : ""}}>{{ $user->name }}</option>
                                                @empty
                                                @endforelse
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label>Ação</label>
                                            <select class="form-control select2" name="action" data-placeholder="Selecione uma ação">
                                                <option></option>
                                                <option value="Inclusão" {{(isset($_GET["action"]) && !empty($_GET["action"]) && $_GET["action"] == "Inclusão") ? "selected" : ""}}>Criação</option>
                                                <option value="Alteração" {{(isset($_GET["action"]) && !empty($_GET["action"]) && $_GET["action"] == "Alteração") ? "selected" : ""}}>Alteração</option>
                                                <option value="Exclusão" {{(isset($_GET["action"]) && !empty($_GET["action"]) && $_GET["action"] == "Exclusão") ? "selected" : ""}}>Exclusão</option>
                                                <option value="Login" {{(isset($_GET["action"]) && !empty($_GET["action"]) && $_GET["action"] == "Login") ? "selected" : ""}}>Login</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label>Descrição</label>
                                            <input type="text" class="form-control" name="description" id="description" value="{{isset($_GET["description"])? $_GET["description"] : ""}}">
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label>Período</label>
                                            <input type="text" class="form-control" name="date_range" id="date_range" value="{{isset($_GET["date_range"])? $_GET["date_range"] : ""}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary " id="btn-external-filter"><i class="bx bx-search"></i> Filtrar</button>
                                        <a href="/{{Route::getCurrentRoute()->uri()}}" class="btn btn-link pull-right"><i class="bx bx-eraser"></i> Limpar</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{--FILTROS FIM--}}

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="box-title">Auditoria</h3>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        @if($activityLog->count())
                            <div class="table-responsive">
                                <table class="table table-condensed table-striped table-sm table-hover" data-order='[[ 0, "desc" ]]' data-page-length='25'>
                                    <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Nome</th>
                                        <th>Usuário</th>
                                        <th>Efetuada</th>

                                        <th class="text-right">Opções</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    @foreach($activityLog as $log)
                                        <tr>
                                            <td>{{$log->id}}</td>
                                            <td>{{$log->log_name}}</td>
                                            <td>{{(is_object($log->user)) ? $log->user->name : '' }}</td>
                                            <td>{{ date('d/m/Y H:i:s', strtotime($log->created_at)) }}</td>
                                            <td class="text-right">
                                                <a href="{{ route('log.show', $log->id) }}" class="btn btn-icon btn-sm btn-primary" data-toggle="tooltip" data-placement="left" title="Exibir"><i class="bx bx-book-open"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            {!! $activityLog->render() !!}
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
    <script src="/bower_components/AdminLTE/plugins/select2/select2.full.min.js"></script>
    <!-- date-range-picker -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
    <script src="/bower_components/AdminLTE/plugins/daterangepicker/daterangepicker.js"></script>
    <script nonce="{{ csp_nonce() }}">
        $(function () {
            //Initialize Select2 Elements
            $(".select2").select2({
                allowClear: true
            });
            //Date range picker
            $('#date_range').daterangepicker({
//                "autoApply": true,
                maxDate: moment(),
                locale: {
                    format: 'DD/MM/YYYY',
                    cancelLabel: 'Limpar',
                    applyLabel: 'Ok'
                }
            });
            @if(!isset($_GET["date_range"]) || empty($_GET["date_range"]))
                $('#date_range').val('');
            @endif
            $('#date_range').on('cancel.daterangepicker', function(ev, picker) {
                //do something, like clearing an input
                $('#date_range').val('');
            });

        });
    </script>
@endsection
