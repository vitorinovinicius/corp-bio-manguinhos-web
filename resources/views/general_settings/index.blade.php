@extends('layouts.frest_template')
@section('css')
    <!-- DataTables -->
    <link rel="stylesheet" href="/js/datatables/dataTables.bootstrap.css">
@endsection
@section('header')
    <div class="page-header clearfix">
        <h2>
            Configurações Gerais
            {{-- @shield('general_setting.create')
            <a class="btn btn-success pull-right" href="{{ route('general_setting.create') }}"><i class="bx bx-plus"></i> Novo</a>
            @endshield --}}
        </h2>
    </div>
@endsection
@section('content-header')
    <div class="content-header-left col-10 mb-2 mt-1">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h5 class="content-header-title float-left pr-1 mb-0">Configurações Gerais</h5>
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb p-0 mb-0">
                        <li class="breadcrumb-item"><i class="bx bx-home-alt"></i> Home</li>
                        <li class="breadcrumb-item active">Configurações Gerais</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="col-2 d-flex justify-content-end align-items-center">
        @shield('general_setting.create')
        {{-- <a class="btn btn-success pull-right" href="{{ route('general_setting.create') }}"><i class="bx bx-plus"></i> Novo</a> --}}
        @endshield
    </div>
@endsection

@section('content')
    @include('messages')
    @include('error')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="box-title">Configurações Gerais</h3>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <form class="form form-vertical" action="{{ route('general_setting.update', optional($settings[0])->uuid) }}" method="POST">
                            <input type="hidden" name="_method" value="PUT">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-12 mt-1 mb-2">
                                        <h4>Keys</h4>
                                        <hr>
                                    </div>
                                </div>

                                <form action="">
                                    <fieldset>
                                        <legend>Google:</legend>
                                        <div class="form-group row">
                                            <label for="google_maps_key" class="col-sm-3 col-form-label">GOOGLE_MAPS_KEY</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="google_maps_key" name="google_maps_key" value="{{optional($settings[0])->google_maps_key}}">
                                            </div>
                                        </div>
                                    </fieldset>

                                    <fieldset>
                                        <legend>S3:</legend>
                                        <div class="form-group row">
                                            <label for="s3_key" class="col-sm-3 col-form-label">S3_KEY
                                                <small>(Conteúdo protegido)</small></label>
                                            <div class="col-sm-9">
                                                <input type="password" class="form-control" id="s3_key" name="s3_key" value="" placeholder="{{string50PorCento(optional($settings[0])->s3_key)}}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="s3_secret" class="col-sm-3 col-form-label">S3_SECRET<small>(Conteúdo protegido)</small></label>
                                            <div class="col-sm-9">
                                                <input type="password" class="form-control" id="s3_secret" name="s3_secret" value="" placeholder="{{string50PorCento(optional($settings[0])->s3_secret)}}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="s3_region" class="col-sm-3 col-form-label">S3_REGION</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="s3_region" name="s3_region" value="{{optional($settings[0])->s3_region}}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="s3_bucket" class="col-sm-3 col-form-label">S3_BUCKET</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="s3_bucket" name="s3_bucket" value="{{optional($settings[0])->s3_bucket}}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="s3_path" class="col-sm-3 col-form-label">S3_PATH</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="s3_path" name="s3_path" value="{{optional($settings[0])->s3_path}}">
                                            </div>
                                        </div>
                                    </fieldset>
                                    <fieldset>
                                        <legend>ZENVIA:</legend>
                                        <div class="form-group row">
                                            <label for="zenvia_account" class="col-sm-3 col-form-label">ZENVIA_ACCOUNT</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="zenvia_account" name="zenvia_account" value="{{optional($settings[0])->zenvia_account}}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="zenvia_password" class="col-sm-3 col-form-label">ZENVIA_PASSWORD
                                                <small>(Conteúdo protegido)</small></label>
                                            <div class="col-sm-9">
                                                <input type="password" class="form-control" id="zenvia_password" name="zenvia_password" value="" placeholder="{{string50PorCento(optional($settings[0])->zenvia_password)}}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="zenvia_from" class="col-sm-3 col-form-label">ZENVIA_FROM</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="zenvia_from" name="zenvia_from" value="{{optional($settings[0])->zenvia_from}}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="zenvia_status" class="col-sm-3 col-form-label">ZENVIA_STATUS</label>
                                            <div class="col-sm-9">
                                                <select class="form-control select2" name="zenvia_status" data-placeholder="Selecione o status">
                                                    <option></option>
                                                    <option value="1" {{(optional($settings[0])->zenvia_status==1 ? "selected":"")}}>Ativo</option>
                                                    <option value="0" {{(optional($settings[0])->zenvia_status==0 ? "selected":"")}}>Inativo</option>
                                                </select>
                                            </div>
                                        </div>
                                    </fieldset>
                                    <fieldset>
                                        <legend>DYNAMODB:</legend>
                                        <div class="form-group row">
                                            <label for="dynamodb_key" class="col-sm-3 col-form-label">DYNAMODB_KEY
                                                <small>(Conteúdo protegido)</small></label>
                                            <div class="col-sm-9">
                                                <input type="password" class="form-control" id="dynamodb_key" name="dynamodb_key" value="" placeholder="{{string50PorCento(optional($settings[0])->dynamodb_key)}}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="dynamodb_secret" class="col-sm-3 col-form-label">DYNAMODB_SECRET
                                                <small>(Conteúdo protegido)</small></label>
                                            <div class="col-sm-9">
                                                <input type="password" class="form-control" id="dynamodb_secret" name="dynamodb_secret" value="" placeholder="{{string50PorCento(optional($settings[0])->dynamodb_secret)}}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="dynamodb_region" class="col-sm-3 col-form-label">DYNAMODB_REGION</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="dynamodb_region" name="dynamodb_region" value="{{optional($settings[0])->dynamodb_region}}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="dynamodb_local_endpoint" class="col-sm-3 col-form-label">DYNAMODB_LOCAL_ENDPOINT</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="dynamodb_local_endpoint" name="dynamodb_local_endpoint" value="{{optional($settings[0])->dynamodb_local_endpoint}}">
                                            </div>
                                        </div>
                                    </fieldset>
                                    <fieldset>
                                        <legend>ENCURTADOR:</legend>
                                        <div class="form-group row">
                                            <label for="bitly_access_token" class="col-sm-3 col-form-label">BITLY_ACCESS_TOKEN
                                                <small>(Conteúdo protegido)</small></label>
                                            <div class="col-sm-9">
                                                <input type="password" class="form-control" id="bitly_access_token" name="bitly_access_token" value="" placeholder="{{string50PorCento(optional($settings[0])->bitly_access_token)}}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="redirect" class="col-sm-3 col-form-label">REDIRECT</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="redirect" name="redirect" value="{{optional($settings[0])->redirect}}">
                                            </div>
                                        </div>
                                    </fieldset>

                                    <div class="row">
                                        <div class="col-12 d-flex justify-content-end">
                                            <button type="submit" class="btn btn-primary">Salvar</button>
                                            <a class="btn btn-link pull-right"
                                               href="/"><i class="bx bx-arrow-back"></i> Voltar</a>
                                        </div>
                                    </div>
                                </form>
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
