@extends('layouts.frest_template')
@section('css')
    <!-- Select2 -->
    <link rel="stylesheet" href="/bower_components/AdminLTE/plugins/select2/select2.min.css">
@endsection

@section('content-header')
    <div class="content-header-left col-12 mb-2 mt-1">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h5 class="content-header-title float-left pr-1 mb-0">Arquivos / Criar</h5>
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb p-0 mb-0">
                        <li class="breadcrumb-item"><i class="bx bx-home-alt"></i> Home</li>
                        <li class="breadcrumb-item">Arquivos</li>
                        <li class="breadcrumb-item active">Criar</li>
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
                    <h3 class="box-title">Criar Formulário</h3>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <form class="form form-vertical" action="{{ route('word.store') }}" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="name">Nome*</label>
                                            <input type="text" class="form-control" name="fileName" value="{{ old('fileName') }}" placeholder="Nome do arquivo" autocomplete="off" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="name">Titulo*</label>
                                            <input type="text" class="form-control" name="title" value="{{ old('title') }}" placeholder="Titulo do arquivo" autocomplete="off" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="name">Corpo do documento</label>
                                            <input type="textarea" class="form-control" name="bodyFile" value="{{ old('bodyFile') }}" placeholder="Escreva o texto que deseja." autocomplete="off">
                                        </div>
                                    </div>
                                </div>                               

                                
                                <div class="row">
                                    <div class="col-12 d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary">Criar</button>
                                        <a class="btn btn-link pull-right"
                                            href="{{ route('users.index') }}"><i
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
                allowClear: false
            });

//            $(".onchangeTipoUser").click(function(e) {
//                if($(this).is(':checked')){
//                   if($(this).val() == 7){
//                       if($(this).is(':checked')){
//                           $("#empresiteiras").hide();
//                       } else {
//                           $("#empresiteiras").show();
//                       }
//                   }else{
//                       if(!$(this).is(':checked')){
//                           $("#empresiteiras").show();
//                       }
//                   }
//                }
//            });

            $('.select2').on('select2:select', function (e) {
                var data = e.params.data;
                if (data.id != 0) {

                    $("#regions").hide();

                    $(".form-check-input").each(function () {
                        $(this).prop('checked', false);
                    });

                } else {
                    $("#regions").show();
                }

            });


        });
    </script>
@endsection
