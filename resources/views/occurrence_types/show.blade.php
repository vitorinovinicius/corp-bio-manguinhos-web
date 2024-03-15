@extends('layouts.frest_template')

@section('content-header')
    <div class="content-header-left col-7 mb-2 mt-1">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h5 class="content-header-title float-left pr-1 mb-0">Tipos de Ocorrência / Exibir #{{$occurrence_type->id}}</h5>
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb p-0 mb-0">
                        <li class="breadcrumb-item"><i class="bx bx-home-alt"></i> Home</li>
                        <li class="breadcrumb-item">Tipos de Ocorrência</li>
                        <li class="breadcrumb-item active">Exibir</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="col-5 d-flex justify-content-end align-items-center">
        <form action="{{ route('occurrence_types.destroy', $occurrence_type->uuid) }}" method="POST" style="display: inline;" onsubmit="if(confirm('Deseja realmente excluir esse item?')) { return true } else {return false };">
            <input type="hidden" name="_method" value="DELETE">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="btn-group pull-right" role="group" aria-label="...">
                @shield('occurrence_type.edit')
                <a class="btn btn-warning" href="{{ route('occurrence_types.edit', $occurrence_type->uuid) }}"><i class="bx bx-edit"></i> Editar</a>
                @endis

                @shield('occurrence_type.destroy')
                <form action="{{ route('occurrence_types.destroy', $occurrence_type->uuid) }}" method="POST" style="display: inline;" onsubmit="if(confirm('Deseja realmente excluir esse item?')) { return true } else {return false };">
                    <input type="hidden" name="_method" value="DELETE">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <button type="submit" class="btn btn-danger"><i class="bx bx-trash"></i> Excluir</button>
                </form>
                @endis
            </div>
        </form>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="box-title">Dados do tipo de ocorrência</h3>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label>ID</label>
                                    <p class="form-control-static" >{{$occurrence_type->id}}</p>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Nome</label>
                                    <p class="form-control-static" >{{$occurrence_type->name}}</p>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Descrição</label>
                                    <p class="form-control-static" >{{$occurrence_type->description}}</p>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Tempo médio de excução</label>
                                    <p class="form-control-static" >{{$occurrence_type->average_time}}</p>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Status</label>
                                    <p class="form-control-static" >{{ ativo_inativo($occurrence_type->status) }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('occurrence_types.skills')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="box-title">Formulários do Tipo de OS</h3>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <div class="row">
                            @foreach($occurrence_type->forms()->orderBy("occurrence_type_forms.id","asc")->get() as $form)
                                <div class="col-12">
                                    <div class="form-group">
                                        <p class="form-control-static" >{{$form->name}}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <a class="btn btn-primary" href="{{ route('occurrence_types.index') }}"><i class="bx bx-arrow-back"></i>  Voltar</a>

@endsection
