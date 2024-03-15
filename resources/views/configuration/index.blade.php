@extends('layouts.frest_template')
@section('css')
@endsection

@section('content-header')
    <div class="content-header-left col-12 mb-2 mt-1">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h5 class="content-header-title float-left pr-1 mb-0">Configurações</h5>
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb p-0 mb-0">
                        <li class="breadcrumb-item"><i class="bx bx-home-alt"></i> Home</li>
                        <li class="breadcrumb-item active">Configurações</li>
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
            <div class="card">
                <div class="card-header">
                    <h3 class="box-title">Configurações</h3>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <form class="form form-vertical" action="{{ route('configuration.store') }}" method="POST">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-12 mt-1 mb-2">
                                        <h4>Configurações gerais</h4>
                                        <hr>
                                    </div>
                                </div>

                                @foreach($configuration->where("contractor_id","=",null) as $config)
                                    <div class="row">
                                        <div class="col-8">{{$config->description}}</div>
                                        <div class="col-4">
                                            <div class="form-group">
                                                @if($config->tipo_form == 1)
                                                    <select name="config[{{$config->id}}]" class="form-control">
                                                        <option value="0" @if($config->config_value == 0) {{'selected'}} @endif >Desativado</option>
                                                        <option value="1" @if($config->config_value == 1) {{'selected'}} @endif >Ativado</option>
                                                    </select>
                                                @endif

                                                @if($config->tipo_form == 2)
                                                    <input type="text" name="config[{{$config->id}}]" value="{{$config->config_value}}" class="form-control" autocomplete="off">
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                                <div class="row">
                                    <div class="col-12 mt-1 mb-2">
                                        <h4>Empreiteiras</h4>
                                        <hr>
                                    </div>
                                </div>

                                @foreach($configuration->where("contractor_id","<>",null) as $config)
                                    <div class="row">
                                        <div class="col-3">{{optional($config->contractor)->name}}</div>
                                        <div class="col-6">{{$config->description}}</div>
                                        <div class="col-3">
                                            <div class="form-group">
                                                @if($config->tipo_form == 1)
                                                    <select name="config[{{$config->id}}]" class="form-control">
                                                        <option value="0" @if($config->config_value == 0) {{'selected'}} @endif >Desativado</option>
                                                        <option value="1" @if($config->config_value == 1) {{'selected'}} @endif >Ativado</option>
                                                    </select>
                                                @endif

                                                @if($config->tipo_form == 2)
                                                    <input type="text" name="config[{{$config->id}}]" value="{{$config->config_value}}" class="form-control" autocomplete="off">
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                                <div class="row">
                                    <div class="col-12 d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary">Salvar</button>
                                        <a class="btn btn-link pull-right"
                                           href="/"><i
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
@endsection
@section('scripts')
@endsection
