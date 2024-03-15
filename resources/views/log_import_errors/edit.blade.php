@extends('layouts.frest_template')

@section('content-header')
    <div class="content-header-left col-12 mb-2 mt-1">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h5 class="content-header-title float-left pr-1 mb-0">Erros de importação / Editar {{$log_import_error->name_archive}}</h5>
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb p-0 mb-0">
                        <li class="breadcrumb-item"><i class="bx bx-home-alt"></i> Home</li>
                        <li class="breadcrumb-item">Importação</li>
                        <li class="breadcrumb-item">Erros de importação</li>
                        <li class="breadcrumb-item active">Editar</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="box-title">Editar o Exame</h3>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <form class="form form-vertical" action="{{ route('log_import_errors.update', $log_import_error->uuid) }}" method="POST">
                            <input type="hidden" name="_method" value="PUT">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="log_import_id">Id de importação</label>
                                            <input type="text" class="form-control" name="log_import_id" value="{{$log_import_error->log_import_id}}" placeholder="Id de importação">
                                        </div>
                                    </div>
                                </div><div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="line_number">Nº da linha</label>
                                            <input type="text" class="form-control" name="line_number" value="{{$log_import_error->line_number}}" placeholder="Nº da linha">
                                        </div>
                                    </div>
                                </div><div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="line_detail">Detalhe da linha</label>
                                            <textarea class="form-control" name="line_detail" placeholder="Detalhe da linha">{!! $log_import_error->line_detail !!}</textarea>
                                        </div>
                                    </div>
                                </div><div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="error_message">Mensagem de erro</label>
                                            <textarea class="form-control" name="error_message" placeholder="Mensagem de erro">{!! $log_import_error->error_message !!}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary">Salvar</button>
                                        <a class="btn btn-link pull-right"
                                           href="{{ route('log_import_errors.index') }}"><i
                                                    class="bx bx-arrow-back"></i> Voltar</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
