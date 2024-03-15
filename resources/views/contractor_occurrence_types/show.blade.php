@extends('layouts.frest_template')

@section('content-header')
    <div class="content-header-left col-10 mb-2 mt-1">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h5 class="content-header-title float-left pr-1 mb-0">Empresas x Ocorrências / Exibir #{{$contractor_occurrence_type->id}}</h5>
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb p-0 mb-0">
                        <li class="breadcrumb-item"><i class="bx bx-home-alt"></i> Home</li>
                        <li class="breadcrumb-item">Empresas x Ocorrências</li>
                        <li class="breadcrumb-item active">Exibir</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="col-2 d-flex justify-content-end align-items-center">
        <form action="{{ route('contractor_occurrence_types.destroy', $contractor_occurrence_type->uuid) }}" method="POST" style="display: inline;" onsubmit="if(confirm('Deseja realmente excluir esse item?')) { return true } else {return false };">
            <input type="hidden" name="_method" value="DELETE">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="btn-group pull-right" role="group" aria-label="...">
                @shield('contractor_occurrence_types.edit')
                <a class="btn btn-warning btn-group" role="group" href="{{ route('contractor_occurrence_types.edit', $contractor_occurrence_type->uuid) }}"><i class="bx bx-edit"></i> Editar</a>
                @endshield
                @shield('contractor_occurrence_types.destroy')
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
                    <h3 class="box-title">Dados do Empresas x Ocorrências</h3>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="name">ID</label>
                                    <p class="form-control-static" >{{$contractor_occurrence_type->id}}</p>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="name">Empresa</label>
                                    <p class="form-control-static" >{{$contractor_occurrence_type->contractor->name}}</p>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="name">OS</label>
                                    <p class="form-control-static" >{{$contractor_occurrence_type->occurrence_type->name}}</p>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="name">Capacidade diária</label>
                                    <p class="form-control-static" >{{$contractor_occurrence_type->capacity}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <a class="btn btn-primary" href="{{ route('contractor_occurrence_types.index') }}"><i class="bx bx-arrow-back"></i> Voltar</a>

@endsection
