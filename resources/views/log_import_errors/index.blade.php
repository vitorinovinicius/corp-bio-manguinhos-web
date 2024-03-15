@extends('layouts.frest_template')

@section('content-header')
    <div class="content-header-left col-12 mb-2 mt-1">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h5 class="content-header-title float-left pr-1 mb-0">Erros de importação</h5>
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb p-0 mb-0">
                        <li class="breadcrumb-item"><i class="bx bx-home-alt"></i> Home</li>
                        <li class="breadcrumb-item">Importação</li>
                        <li class="breadcrumb-item active">Erros de importação</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    @include('messages')
    @include('error')

    <div class="row">
        <div class="col-12">
            @if($log_import_errors->count())
                <div class="card">
                    <div class="card-header">
                        <h3 class="box-title">Erros de importação</h3>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <table class="table table-condensed table-striped table-sm table-hover">
                                <thead>
                                <tr>
                                    <th>Import ID</th>
                                    <th>Número da linha</th>
                                    <th>Detalhes</th>
                                    <th>Mensagem</th>
                                    <th>Criado em</th>

                                    <th class="text-right">Opções</th>
                                </tr>
                                </thead>

                                <tbody>
                                @foreach($log_import_errors as $log_import_error)
                                    <tr>
                                        <td>{{$log_import_error->log_import_id}}</td>
                                        <td>{{$log_import_error->line_number}}</td>
                                        <td>{{$log_import_error->line_detail}}</td>
                                        <td>{{$log_import_error->error_message}}</td>
                                        <td>{{ date('d/m/Y H:i:s', strtotime($log_import_error->created_at)) }}</td>

                                        <td class="text-right">
                                            @shield('log_import_errors.show')
                                            <a href="{{ route('log_import_errors.show', $log_import_error->uuid) }}" class="btn btn-icon btn-sm btn-primary" data-toggle="tooltip" data-placement="left" title="Exibir"><i class="bx bx-book-open"></i></a>
                                            @endshield
                                            @shield('log_import_errors.edit')
                                            <a href="{{ route('log_import_errors.edit', $log_import_error->uuid) }}" class="btn btn-icon btn-sm btn-warning" data-toggle="tooltip" data-placement="left" title="Editar"><i class="bx bx-pencil"></i></a>
                                            @endshield
                                            @shield('log_import_errors.destroy')
                                            <form action="{{ route('log_import_errors.destroy', $log_import_error->uuid) }}"
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
                        </div>
                    </div>
                </div>
            @else
                <h3 class="text-center alert alert-info">Vazio!</h3>
            @endif
        </div>
    </div>

@endsection
