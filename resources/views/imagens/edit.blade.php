@extends('layouts.frest_template')
@section('css')
    <!-- Select2 -->
    <link rel="stylesheet" href="/bower_components/AdminLTE/plugins/select2/select2.min.css">
@endsection

@section('content-header')
    <div class="content-header-left col-12 mb-2 mt-1">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb p-0 mb-0">
                        <li class="breadcrumb-item"><i class="bx bx-home-alt"></i> Home</li>
                        <li class="breadcrumb-item">Formulários</li>
                        <li class="breadcrumb-item ">Exibir</li>
                        <li class="breadcrumb-item active">Editar imagem</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')

    <div class="row">
        <div class="col-12">
            
                <div class="card">
                    <div class="card-header">
                        <div class="col-12">
                            <h5 class="box-title">Editar imagem #{{$imagem->id}}</h5>
                        </div>
                    </div>
                    <hr>
                    <div class="card-content">
                        <form class="form form-vertical" action="{{ route('imagens.update', [$imagem->uuid]) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="texto_salvo">Legenda</label>
                                                <input type="text" class="form-control" name="legenda" value="{{$imagem->legenda }}">
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="card">
                                                <div class="card-content">
                                                    <div class="card-body">
                                                        <div>
                                                            <img src="{{ asset($imagem->url_imagem) }}" alt="{{ $imagem->legenda }}" class="card-img-top">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary">Salvar</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="modal-footer">
                            <a class="btn btn-link  pull-left" href="{{route('forms.index')}}"><i class="bx bx-arrow-back"></i> Voltar</a>
                        </div>
                    </div>
                </div>
        </div>
    </div>
@endsection
@section('scripts')
@if(session('message'))
    <script>
        Swal.fire({
            position: "center",
            icon: "success",
            title: '{{ session('message') }}',
            showConfirmButton: false,
            timer: 1500
        });
    </script>
@endif
@endsection