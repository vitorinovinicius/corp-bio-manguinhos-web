@extends('layouts.adminlte')
@section('header')
    <div class="page-header clearfix">
        <h2>
            <i class="bx bx-map"></i> Log de importação / Exibir
            <small>{{$log_import->name_archive}}</small>
        </h2>
    </div>
@endsection

@section('content')
    @if(Session::has('message'))
        <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Fechar">
                <span aria-hidden="true">&times;</span></button>
            <span class="bx bx-ok"></span><em> {!! session('message') !!}</em></div>
    @endif
    <div class="col-md-12">
        <!-- Horizontal Form -->
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">Exibir Log de importação</h3>
            </div>
            <div class="box-body">
                <div class="form-group col-md-6">
                    <label for="id">ID</label>
                    <span class="form-control-static">{{$log_import->id}}</span>
                </div>
                <div class="form-group col-md-6">
                    <label for="name_archive">Nome do arquivo</label>
                    <span class="form-control-static">{{$log_import->name_archive}}</span>
                </div>
                <div class="col-md-12">
                    <div class="form-group col-md-2">
                        <label for="qtd_error">Qtd erros</label>
                        <span class="form-control-static">{{$log_import->qtd_error}}</span>
                    </div>
                    <div class="form-group col-md-2">
                        <label for="qtd_success">Qtd oks</label>
                        <span class="form-control-static">{{$log_import->qtd_success}}</span>
                    </div>
                    <div class="form-group col-md-2">
                        <label for="lines">Total de linhas</label>
                        <span class="form-control-static">{{$log_import->lines}}</span>
                    </div>
                </div>
            </div>

            @if($log_import_errors->count())
                <div class="box box-info">
                    <div class="box-body">
                        <table class="table table-condensed table-striped table-sm table-hover">
                            <thead>
                            <tr>
                                <th>Linha</th>
                                <th>Detalhes</th>
                                <th>Motivo</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach($log_import_errors as $log_import_error)
                                <tr>
                                    <td>{{$log_import_error->line_number}}</td>
                                    <td>{{$log_import_error->line_detail}}</td>
                                    <td>{{$log_import_error->error_message}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @else
                <h4 class="text-center text-red">Não há erros para essa importação!</h4>
            @endif


            <div class="box-footer">
                <a class="btn btn-link" href="{{ route('log_imports.index') }}"><i class="bx bx-arrow-back"></i> Voltar</a>

                @if(!empty($log_import->url))
                    <div class="btn-group pull-right" role="group" aria-label="...">
                        <a class="btn btn-info btn-group" role="group" href="{{$log_import->url}}" target="_blank"><i class="bx bx-download-alt"></i> Baixar arquivo importado</a>
                    </div>
                @endif
            </div>

        </div>
    </div>

@endsection
