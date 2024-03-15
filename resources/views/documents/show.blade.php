@extends('layouts.frest_template')

@section('content-header')
    <div class="content-header-left col-10 mb-2 mt-1">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h5 class="content-header-title float-left pr-1 mb-0">Documentos / Exibir #{{$document->id}}</h5>
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb p-0 mb-0">
                        <li class="breadcrumb-item"><i class="bx bx-home-alt"></i> Home</li>
                        <li class="breadcrumb-item">Documentos</li>
                        <li class="breadcrumb-item active">Exibir</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="col-2 d-flex justify-content-end align-items-center">
        <form action="{{ route('documents.destroy', $document->uuid) }}" method="POST" style="display: inline;" onsubmit="if(confirm('Deseja realmente excluir esse item?')) { return true } else {return false };">
            <input type="hidden" name="_method" value="DELETE">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="btn-group pull-right" role="group" aria-label="...">
                @shield('document.edit')
                <a class="btn btn-warning btn-group" role="group" href="{{ route('documents.edit', $document->uuid) }}"><i class="bx bx-edit"></i> Editar</a>
                @endshield
                @shield('document.destroy')
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
                    <h3 class="box-title">Dados do documento</h3>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Título</label>
                                    <p class="form-control-static" >{{ $document->titulo }}</p>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Versão</label>
                                    <p class="form-control-static" >{{ $document->version }}</p>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Documento</label>
                                    <p class="form-control-static" ><a href="{{$document->url_documento}}" target="_blank" class="btn btn-primary" download>Baixar arquivo</a></p>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Status</label>
                                    <p class="form-control-static" >{{ $document->status() }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <a class="btn btn-link" href="{{ route('documents.index') }}"><i class="bx bx-arrow-back"></i>  Voltar</a>

@endsection
