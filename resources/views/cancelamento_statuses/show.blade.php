@extends('layouts.frest_template')

@section('content-header')
    <div class="content-header-left col-9 mb-2 mt-1">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h5 class="content-header-title float-left pr-1 mb-0">Motivo de Não realizado / Exibir #{{$cancelamento_status->id}}</h5>
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb p-0 mb-0">
                        <li class="breadcrumb-item"><i class="bx bx-home-alt"></i> Home</li>
                        <li class="breadcrumb-item">Motivo de Não realizado</li>
                        <li class="breadcrumb-item active">Exibir</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="col-3 d-flex justify-content-end align-items-center">
        <form action="{{ route('cancelamento_statuses.destroy', $cancelamento_status->id) }}" method="POST" style="display: inline;" onsubmit="if(confirm('Deseja realmente excluir esse item?')) { return true } else {return false };">
            <input type="hidden" name="_method" value="DELETE">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="btn-group pull-right" role="group" aria-label="...">
                @shield('cancelamento_status.edit')
                <a class="btn btn-warning btn-group" role="group" href="{{ route('cancelamento_statuses.edit', $cancelamento_status->id) }}"><i class="bx bx-edit"></i> Editar</a>
                @endshield
                @shield('cancelamento_status.destroy')
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
                    <h3 class="box-title">Dados do status de cancelamento</h3>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="name">ID</label>
                                    <p class="form-control-static" >{{$cancelamento_status->id}}</p>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="name">ID</label>
                                    <p class="form-control-static" >{{$cancelamento_status->name}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <a class="btn btn-primary" href="{{ route('cancelamento_statuses.index') }}"><i class="bx bx-arrow-back"></i> Voltar</a>
@endsection
