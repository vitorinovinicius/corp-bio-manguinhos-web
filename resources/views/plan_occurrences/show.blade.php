@extends('layouts.frest_template')
@section('css')
    <link rel="stylesheet" href="/bower_components/AdminLTE/plugins/select2/select2.min.css">
@endsection

@section('content-header')
    <div class="content-header-left col-10 mb-2 mt-1">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h5 class="content-header-title float-left pr-1 mb-0">Plano de manutenção</h5>
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb p-0 mb-0">
                        <li class="breadcrumb-item"><i class="bx bx-home-alt"></i> Home</li>
                        <li class="breadcrumb-item active">Plano de manutenção</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="col-2 d-flex justify-content-end align-items-center">

        <form action="{{ route('plan_occurrences.destroy', $planOccurrence->uuid) }}" method="POST" style="display: inline;" onsubmit="if(confirm('Deseja realmente excluir esse item?')) { return true } else {return false };">
            <input type="hidden" name="_method" value="DELETE">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="btn-group pull-right" role="group" aria-label="...">
                @shield('plan_occurrences.edit')
                <a class="btn btn-warning btn-group" role="group" href="{{route('plan_occurrences.edit', $planOccurrence->uuid)}}"><i class="bx bx-edit"></i> Editar</a>
                @endshield
                @shield('plan_occurrences.destroy')
                <button type="submit" class="btn btn-danger">Excluir <i class="bx bx-trash"></i></button>
                @endshield
            </div>
        </form>

    </div>
@endsection

@section('content')
    @include('messages')
    @include('error')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="box-title">Dados do plano de manutenção #{{$planOccurrence->id}}</h3>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <div class="row">
                            @is('superuser')
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Empreiteira</label>
                                    <p class="form-control-static" >{{$planOccurrence->contractor->name}}</p>
                                </div>
                            </div>
                            @endis
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Tipo de OS</label>
                                    <p class="form-control-static" >{{$planOccurrence->occurrenceType->name}}</p>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Cliente</label>
                                    <p class="form-control-static" >{{$planOccurrence->occurrenceClient->name}}</p>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Técnico</label>
                                    <p class="form-control-static" >{{$planOccurrence->operator->name}}</p>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Final de Semana</label>
                                    <p class="form-control-static" >@if($planOccurrence->weekend == 1) SIM @else NÃO @endif</p>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Status</label>
                                    <p class="form-control-static" >@if($planOccurrence->status == 1) Ativo @else Inativo @endif</p>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Periodicidade</label>
                                    <p class="form-control-static" >{{$planOccurrence->schedule}}</p>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Data Inicio</label>
                                    <p class="form-control-static" >{{$planOccurrence->date_begin()}}</p>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Data Fim</label>
                                    <p class="form-control-static" >{{$planOccurrence->date_finish()}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="box-title">Serviços - Todos</h3>
                </div>
                @php
                    $occurrences = $planOccurrence->occurrences()->paginate();
                @endphp
                @include('occurrences.helpers.list_default')
            </div>
        </div>
    </div>


    @if(strpos(URL::previous(), route('plan_occurrences.index')) !== false)
        <a class="btn btn-primary" href="{{ URL::previous() }}"><i class="bx bx-arrow-back"></i> Voltar</a>
    @else
        <a class="btn btn-primary" href="{{ route('plan_occurrences.index') }}"><i class="bx bx-arrow-back"></i> Voltar</a>
    @endif
@endsection

@section('scripts')
    <!-- Select2 -->
    <script src="/bower_components/AdminLTE/plugins/select2/select2.full.min.js"></script>
    <script src="{{ url('/js/jQueryRotate.js') }}"></script>
    <script nonce="{{ csp_nonce() }}">
        $(function () {
            //Initialize Select2 Elements
            $(".select2").select2({
                allowClear: true,
                width: "100%"
            });
        });

    </script>
@endsection
