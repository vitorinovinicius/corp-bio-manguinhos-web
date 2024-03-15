@extends('layouts.frest_template')

@section('content-header')
    <div class="content-header-left col-10 mb-2 mt-1">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h5 class="content-header-title float-left pr-1 mb-0">Jornada do dia / Exibir #{{$finishWorkDay->id}}</h5>
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb p-0 mb-0">
                        <li class="breadcrumb-item"><i class="bx bx-home-alt"></i> Home</li>
                        <li class="breadcrumb-item">Jornada do dia</li>
                        <li class="breadcrumb-item active">Exibir</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="box-title">Exibição</h3>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="name">Empreiteira</label>
                                    <p class="form-control-static" >{{optional($finishWorkDay->contractor)->name}}</p>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="name">Técnico</label>
                                    <p class="form-control-static" >{{optional($finishWorkDay->operator)->name}}</p>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="name">Status</label>
                                    <p class="form-control-static" >{{status_work_day($finishWorkDay->status)}}</p>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="name">Data da gravação</label>
                                    <p class="form-control-static" >{{date('d/m/Y H:i:s', strtotime($finishWorkDay->date_record))}}</p>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="name">Data da gravação</label>
                                    <p class="form-control-static" >{{date('d/m/Y H:i:s', strtotime($finishWorkDay->date_record))}}</p>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="name">Relatório de Envio</label>
                                    <p class="form-control-static" >
                                        @foreach(json_decode($finishWorkDay->ocurrences_report)[0] as $key=>$value)
                                            {{$key}} = {{ $value }} <br>
                                        @endforeach
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <a class="btn btn-primary" href="{{ route('finish_work_days.index') }}"><i class="bx bx-arrow-back"></i> Voltar</a>

@endsection
