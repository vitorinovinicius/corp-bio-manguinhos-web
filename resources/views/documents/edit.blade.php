@extends('layouts.frest_template')
@section('css')
@endsection

@section('content-header')
    <div class="content-header-left col-12 mb-2 mt-1">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h5 class="content-header-title float-left pr-1 mb-0">Documentos / Editar #{{$document->id}}</h5>
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb p-0 mb-0">
                        <li class="breadcrumb-item"><i class="bx bx-home-alt"></i> Home</li>
                        <li class="breadcrumb-item">Documentos</li>
                        <li class="breadcrumb-item active">Editar</li>
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
                    <h3 class="box-title">Editar Documento</h3>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <form class="form form-vertical" action="{{ route('documents.update', $document->uuid) }}" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="_method" value="PUT">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-goup">
                                            <label>Título</label>
                                            <input type="text" class="form-control" name="titulo" value="{{ (old('titulo'))? old('titulo') : $document->titulo}}" placeholder="Título"  autocomplete="off" required>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-goup">
                                            <label>Versão</label>
                                            <input type="number" class="form-control" name="version" value="{{ (old('version'))? old('version') : $document->version}}" placeholder="1.0"  autocomplete="off" required>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-goup">
                                            <label>Documento</label>
                                            @if($document->url_documento)
                                                <p class="form-control-static" ><a href="{{$document->url_documento}}" target="_blank" class="btn btn-primary" download>Baixar arquivo</a></p>
                                            @endif

                                            <input type="file" class="form-control" name="url_documento" value="{{ old('url_documento') }}" placeholder="url_documento" {{$document->url_documento? "" : "required"}}>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-goup">
                                            <label>Status</label>
                                            <select class="form-control select2" name="status" data-placeholder="Selecione um status" required>
                                                <option value="1" {{($document->status == 1) ?  "SELECTED" : "" }}>Ativo</option>
                                                <option value="0" {{($document->status == 0) ?  "SELECTED" : "" }}>Inativo</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12 d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary">Salvar</button>
                                        <a class="btn btn-link pull-right"
                                           href="{{ route('documents.index') }}"><i
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
  <script>
  </script>
@endsection
