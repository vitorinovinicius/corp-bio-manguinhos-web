@extends('layouts.frest_template')
@section('css')
        <!-- Select2 -->
  <link rel="stylesheet" href="/bower_components/AdminLTE/plugins/select2/select2.min.css">
@endsection
@section('content-header')
    <div class="content-header-left col-12 mb-2 mt-1">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h5 class="content-header-title float-left pr-1 mb-0">Log de importação / Editar {{$log_import->name_archive}}</h5>
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb p-0 mb-0">
                        <li class="breadcrumb-item"><i class="bx bx-home-alt"></i> Home</li>
                        <li class="breadcrumb-item">Importação</li>
                        <li class="breadcrumb-item">Logs de importação</li>
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
                        <form class="form form-vertical" action="{{ route('log_imports.update', $log_import->uuid) }}" method="POST">
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

     <div class="col-md-6">
        <!-- Horizontal Form -->
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">Editar o Exame</h3>
            </div>
            <form action="{{ route('log_imports.update', $log_import->uuid) }}" method="POST">
                <div class="box-body">
                    <input type="hidden" name="_method" value="PUT">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    <div class="form-group">
                        <label for="user_id">Usuário</label>
                        <div>
                           <select class="form-control select2" name="user_id" required data-placeholder="Selecione um usuário" required>
                                <option></option>
                            @forelse($users as $user)
                                    <option value="{{$user->id}}" {{$log_import->user_id == $user->id ? "selected" : ""}}>{{$user->name}}</option>
                                @empty
                                @endforelse
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name_archive">Nome do arquivo</label>
                        <div><input type="text" class="form-control" name="name_archive" value="{{$log_import->name_archive}}" placeholder="Nome do arquivo"></div>
                    </div>
                    <div class="form-group">
                        <label for="qtd_error">Qtd erros</label>
                        <div><input type="text" class="form-control" name="qtd_error" value="{{$log_import->qtd_error}}" placeholder="Qtd Erros"></div>
                    </div>
                    <div class="form-group">
                        <label for="qtd_success">Qtd oks</label>
                        <div><input type="text" class="form-control" name="qtd_success" value="{{$log_import->qtd_success}}" placeholder="Qtd oks"></div>
                    </div>
                    <div class="form-group">
                        <label for="lines">Total de linhas</label>
                        <div><input type="text" class="form-control" name="lines" value="{{$log_import->lines}}" placeholder="Total de linhas"></div>
                    </div>
                    <div class="form-group">
                        <label for="archive_path">Caminho do arquivo</label>
                        <div><input type="text" class="form-control" name="archive_path" value="{{$log_import->archive_path}}" placeholder="Caminho"></div>
                    </div>
                </div>

                <div class="box-footer">
                    <a class="btn btn-link" href="{{ route('log_imports.index') }}"><i class="bx bx-arrow-back"></i> Voltar</a>
                    <button type="submit" class="btn btn-primary pull-right">Salvar</button>
                </div>
            </form>

        </div>
    </div>
@endsection
@section('scripts')
            <!-- Select2 -->
    <script src="/bower_components/AdminLTE/plugins/select2/select2.full.min.js"></script>
    <script nonce="{{ csp_nonce() }}">
        $(function () {
            //Initialize Select2 Elements
            $(".select2").select2({
                allowClear: true
            });
        });
    </script>
@endsection
