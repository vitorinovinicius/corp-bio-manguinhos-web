@extends('layouts.adminlte')
@section('header')
<div class="page-header">
        <h3>Configurações / Exibir #{{$configuration->id}}</h3>
        <form action="{{ route('configurations.destroy', $configuration->uuid) }}" method="POST" style="display: inline;" onsubmit="if(confirm('Deseja realmente excluir esse item?')) { return true } else {return false };">
            <input type="hidden" name="_method" value="DELETE">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="btn-group pull-right" role="group" aria-label="...">
                @shield('configurations.edit')
                    <a class="btn btn-warning btn-group" role="group" href="{{ route('configurations.edit', $configuration->uuid) }}"><i class="bx bx-edit"></i> Editar</a>
                @endshield
                @shield('configurations.destroy')
                    <button type="submit" class="btn btn-danger">Excluir <i class="bx bx-trash"></i></button>
                @endshield
            </div>
        </form>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-default">
                <div class="box-body">
                    <div class="form-group col-md-12">
                        <label for="contractor_id">Empreireira</label>
                        <div class="form-control input-static">{{ $configuration->contractor_id }}</div>
                    </div>
                    <div class="form-group col-md-12">
                        <label for="config_value">Valor</label>
                        <div class="form-control input-static">{{ $configuration->config_value }}</div>
                    </div>
                    <div class="form-group col-md-12">
                        <label for="config_key">Chave</label>
                        <div class="form-control input-static">{{ $configuration->config_key }}</div>
                    </div>
                    <div class="form-group col-md-12">
                        <label for="description">Descrição</label>
                        <div class="form-control input-static">{{ $configuration->description }}</div>
                    </div>
                    <div class="form-group col-md-12">
                        <label for="tipo">Tipo</label>
                        <div class="form-control input-static">{{ $configuration->tipo }}</div>
                    </div>
                    <div class="form-group col-md-12">
                        <label for="tipo_user">Tipo do usuário</label>
                        <div class="form-control input-static">{{ $configuration->tipo_user }}</div>
                    </div>
                    <div class="form-group col-md-12">
                        <label for="tipo_form">Tipo do formulário</label>
                        <div class="form-control input-static">{{ $configuration->tipo_form }}</div>
                    </div>

                </div>
                <a class="btn btn-link" href="{{ route('configurations.index') }}"><i class="bx bx-arrow-back"></i>  Voltar</a>
            </div>
        </div>
    </div>

@endsection
