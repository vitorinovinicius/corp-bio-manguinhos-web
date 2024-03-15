@extends('layouts.adminlte')
@section('css')
@endsection
@section('header')
    <div class="page-header">
        <h3>Configurações / Editar #{{$configuration->id}}</h3>
    </div>
    <ol class="breadcrumb">
        <li><a href="/admin"><i class="bx bx-dashboard"></i> Home</a></li>
        <li> Configurações</li>
        <li class="active">Editar</li>
    </ol>
@endsection

@section('content')
    @include('messages')
    @include('error')

    <div class="row">
        <div class="col-md-12">
            <div class="box box-default">
                <form action="{{ route('configurations.update', $configuration->uuid) }}" method="POST">
                    <div class="box-info padding-10">
                        <input type="hidden" name="_method" value="PUT">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        <div class="form-group col-md-12 {{ $errors->has('contractor_id') ? ' has-error' : '' }}">
                            <label for="contractor_id">Empreireira</label>
                            <input type="text" class="form-control" id="contractor_id" name="contractor_id" value="{{ (old('contractor_id'))? old('contractor_id') : $configuration->contractor_id}}" placeholder="Empreireira" autocomplete="off">
                        </div>
                        <div class="form-group col-md-12 {{ $errors->has('config_value') ? ' has-error' : '' }}">
                            <label for="config_value">Valor</label>
                            <input type="text" class="form-control" id="config_value" name="config_value" value="{{ (old('config_value'))? old('config_value') : $configuration->config_value}}" placeholder="Valor" autocomplete="off" required>
                        </div>
                        <div class="form-group col-md-12 {{ $errors->has('config_key') ? ' has-error' : '' }}">
                            <label for="config_key">chave</label>
                            <input type="text" class="form-control" id="config_key" name="config_key" value="{{ (old('config_key'))? old('config_key') : $configuration->config_key}}" placeholder="Chave" autocomplete="off" required>
                        </div>
                        <div class="form-group col-md-12 {{ $errors->has('description') ? ' has-error' : '' }}">
                            <label for="description">Descrição</label>
                            <input type="text" class="form-control" id="description" name="description" value="{{ (old('description'))? old('description') : $configuration->description}}" placeholder="Descrição" autocomplete="off" required>
                        </div>
                        <div class="form-group col-md-12 {{ $errors->has('tipo') ? ' has-error' : '' }}">
                            <label for="tipo">Tipo</label>
                            <input type="text" class="form-control" id="tipo" name="tipo" value="{{ (old('tipo'))? old('tipo') : $configuration->tipo}}" placeholder="Tipo" autocomplete="off" required>
                        </div>
                        <div class="form-group col-md-12 {{ $errors->has('tipo_user') ? ' has-error' : '' }}">
                            <label for="tipo_user">Tipo usuário</label>
                            <input type="text" class="form-control" id="tipo_user" name="tipo_user" value="{{ (old('tipo_user'))? old('tipo_user') : $configuration->tipo_user}}" placeholder="Tipo usuário" autocomplete="off" required>
                        </div>
                        <div class="form-group col-md-12 {{ $errors->has('tipo_form') ? ' has-error' : '' }}">
                            <label for="tipo_form">Tipo formulário</label>
                            <input type="text" class="form-control" id="tipo_form" name="tipo_form" value="{{ (old('tipo_form'))? old('tipo_form') : $configuration->tipo_form}}" placeholder="Tipo formulário" autocomplete="off" required>
                        </div>

                    </div>
                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary">Salvar</button>
                        <a class="btn btn-link pull-right" href="{{ route('configurations.index') }}"><i class="bx bx-arrow-back"></i>  Voltar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
  <script>
  </script>
@endsection
