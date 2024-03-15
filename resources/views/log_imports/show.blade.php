@extends('layouts.frest_template')

@section('content-header')
    <div class="content-header-left col-10 mb-2 mt-1">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h5 class="content-header-title float-left pr-1 mb-0">Log de importação / Exibir #{{$log_import->id}}</h5>
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb p-0 mb-0">
                        <li class="breadcrumb-item"><i class="bx bx-home-alt"></i> Home</li>
                        <li class="breadcrumb-item">Log de importação</li>
                        <li class="breadcrumb-item active">Exibir</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="col-2 d-flex justify-content-end align-items-center">
        <form action="{{ route('log_imports.destroy', $log_import->uuid) }}" method="POST" style="display: inline;" onsubmit="if(confirm('Deseja realmente excluir esse item?')) { return true } else {return false };">
            <input type="hidden" name="_method" value="DELETE">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="btn-group pull-right" role="group" aria-label="...">
                @shield('log_import_errors.edit')
                <a class="btn btn-warning btn-group" role="group" href="{{ route('log_imports.edit', $log_import->uuid) }}"><i class="bx bx-edit"></i> Editar</a>
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
                    <h3 class="box-title">Exibir Log de importação</h3>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-1">
                                <div class="form-group">
                                    <label>Id</label>
                                    <p class="form-control-static">{{$log_import->id}}</p>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label>Usuário que importou</label>
                                    <p class="form-control-static">{{optional($log_import->user)->name}}</p>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Nome original do arquivo</label>
                                    <p class="form-control-static">{{$log_import->original_name}}</p>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Nome atual do arquivo</label>
                                    <p class="form-control-static">{{$log_import->name_archive}}</p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
{{--                            <div class="col-3">--}}
{{--                                <div class="form-group">--}}
{{--                                    <label>Caminho do arquivo</label>--}}
{{--                                    <p class="form-control-static">{{$log_import->archive_path}}</p>--}}
{{--                                </div>--}}
{{--                            </div>--}}
                            <div class="col-3">
                                <div class="form-group">
                                    <label>Qtd alertas</label>
                                    <p class="form-control-static">{{$log_import->qtd_error}}</p>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label>Qtd oks</label>
                                    <p class="form-control-static">{{$log_import->qtd_success}}</p>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label>Total de linhas úteis</label>
                                    <p class="form-control-static">{{$log_import->lines}}</p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Criado em</label>
                                    <p class="form-control-static">{{ date('d/m/Y H:i:s', strtotime($log_import->created_at)) }}</p>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Modificado em</label>
                                    <p class="form-control-static">{{ date('d/m/Y H:i:s', strtotime($log_import->updated_at)) }}</p>
                                </div>
                            </div>
                        </div>

                        @if(!empty($log_import->url))
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <a class="btn btn-info btn-group" role="group" href="{{$log_import->url}}" target="_blank"><i class="bx bx-download-alt"></i> Baixar arquivo importado</a>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if($log_import->logImportErrors->count())
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="box-title">Erros e alertas da importação</h3>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <table class="table table-condensed table-striped table-sm table-hover">
                                <thead>
                                <tr>
                                    <th>Linha</th>
                                    <th>Detalhes</th>
                                    <th>Motivo</th>
                                </tr>
                                </thead>

                                <tbody>
                                @foreach($log_import->logImportErrors as $log_import_error)
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
                </div>
            </div>
        </div>
    @else
        <div class="col-12">
            <h4 class="text-center text-red">Não há erros para essa importação!</h4>
        </div>
    @endif

    @if(strpos(URL::previous(), route('log_import_errors.index')) !== false)
        <a class="btn btn-primary" href="{{ URL::previous() }}"><i class="bx bx-arrow-back"></i> Voltar</a>
    @else
        <a class="btn btn-primary" href="{{ route('log_import_errors.index') }}"><i class="bx bx-arrow-back"></i> Voltar</a>
    @endif
@endsection
