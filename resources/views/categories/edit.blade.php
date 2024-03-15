@extends('layouts.frest_template')
@section('css')
    <!-- Select2 -->
    <link rel="stylesheet" href="/bower_components/AdminLTE/plugins/select2/select2.min.css">
@endsection

@section('content-header')
    <div class="content-header-left col-12 mb-2 mt-1">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h5 class="content-header-title float-left pr-1 mb-0">Categoria / Editar #{{$category->id}}</h5>
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb p-0 mb-0">
                        <li class="breadcrumb-item"><i class="bx bx-home-alt"></i> Home</li>
                        <li class="breadcrumb-item">Categorias</li>
                        <li class="breadcrumb-item active">Editar</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="box-title">Editar categoria - #{{$category->id}}</h3>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <form class="form form-vertical" action="{{ route('categories.update', $category->uuid) }}" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="_method" value="PUT">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="name">Nome</label>
                                            <input type="text" id="name" class="form-control" name="name" value="{{$category->name}}" placeholder="Nome" required>
                                        </div>
                                    </div>
                                    @if((Auth::user()->name) == "Superuser")
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="Validade">Empreiteira</label>
                                            <select class="form-control select2" name="contractor" placeholder="Selecione uma empreiteira">
                                                <option></option>
                                                @foreach($contractors as $contractor)
                                                    <option value="{{$contractor->id}}" @if($contractor->id == $category->contractor_id) SELECTED @endif>{{$contractor->name}}</option>
                                                @endforeach                                      
                                            </select>
                                        </div>
                                    </div>                                  
                                    @endif                                    
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="status">Status</label>
                                            <select class="form-control select2" name="status" placeholder="Selecione o status do equipamento">
                                                <option></option>
                                                <option value="1" @if($category->status == 1) SELECTED @endif >Ativa</option>
                                                <option value="2" @if($category->status == 2) SELECTED @endif >Inativa</option>
                                               
                                            </select>
                                        </div>
                                    </div>                                  
                                </div>

                                <div class="row">
                                    <div class="col-12 d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary">Salvar</button>
                                        <a class="btn btn-link pull-right"
                                           href="{{ route('equipments.index') }}"><i
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
    <!-- Select2 -->
    <script src="/bower_components/AdminLTE/plugins/select2/select2.full.min.js"></script>
    <script nonce="{{ csp_nonce() }}">
        $(function () {
            //Initialize Select2 Elements
            $(".select2").select2({
                placeholder: "Selecione uma empreiteira",
                allowClear: true
            });
        });
    </script>
@endsection
