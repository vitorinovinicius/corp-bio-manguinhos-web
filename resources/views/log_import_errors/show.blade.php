@extends('layouts.frest_template')
@section('content-header')
    <div class="content-header-left col-10 mb-2 mt-1">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h5 class="content-header-title float-left pr-1 mb-0">Erros de importação / Exibir #{{$log_import_error->id}}</h5>
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb p-0 mb-0">
                        <li class="breadcrumb-item"><i class="bx bx-home-alt"></i> Home</li>
                        <li class="breadcrumb-item">Erros de importação</li>
                        <li class="breadcrumb-item active">Exibir</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="col-2 d-flex justify-content-end align-items-center">
        <form action="{{ route('log_import_errors.destroy', $log_import_error->uuid) }}" method="POST" style="display: inline;" onsubmit="if(confirm('Deseja realmente excluir esse item?')) { return true } else {return false };">
            <input type="hidden" name="_method" value="DELETE">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="btn-group pull-right" role="group" aria-label="...">
                @shield('log_import_errors.edit')
                <a class="btn btn-warning btn-group" role="group" href="{{ route('log_import_errors.edit', $log_import_error->uuid) }}"><i class="bx bx-edit"></i> Editar</a>
                @endshield
                @shield('log_import_errors.destroy')
                <button type="submit" class="btn btn-danger">Excluir <i class="bx bx-trash"></i></button>
                @endshield
            </div>
        </form>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="box-title">Dados do cliente</h3>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="log_import_id">Id de importação</label>
                                    <p class="form-control-static">{{$log_import_error->log_import_id}}</p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="line_number">Nº da linha</label>
                                    <p class="form-control-static">{{$log_import_error->line_number}}</p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="line_detail">Detalhe da linha</label>
                                    <p class="form-control-static">{!! $log_import_error->line_detail !!}</p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="error_message">Mensagem de erro</label>
                                    <p class="form-control-static">{!! $log_import_error->error_message !!}</p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="nome">Criado em</label>
                                    <p class="form-control-static">{{ date('d/m/Y H:i:s', strtotime($log_import_error->created_at)) }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="nome">Modificado em</label>
                                    <p class="form-control-static">{{ date('d/m/Y H:i:s', strtotime($log_import_error->updated_at)) }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if(strpos(URL::previous(), route('log_import_errors.index')) !== false)
        <a class="btn btn-primary" href="{{ URL::previous() }}"><i class="bx bx-arrow-back"></i> Voltar</a>
    @else
        <a class="btn btn-primary" href="{{ route('log_import_errors.index') }}"><i class="bx bx-arrow-back"></i> Voltar</a>
    @endif

@endsection
