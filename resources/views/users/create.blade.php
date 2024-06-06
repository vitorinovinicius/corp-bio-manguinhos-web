@extends('layouts.frest_template')
@section('css')
    <!-- Select2 -->
    <link rel="stylesheet" href="/bower_components/AdminLTE/plugins/select2/select2.min.css">
@endsection

@section('content-header')
    <div class="content-header-left col-12 mb-2 mt-1">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h5 class="content-header-title float-left pr-1 mb-0">Usuários / Criar</h5>
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb p-0 mb-0">
                        <li class="breadcrumb-item"><i class="bx bx-home-alt"></i> Home</li>
                        <li class="breadcrumb-item">Usuários</li>
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
                    <h3 class="box-title">Criar Usuário</h3>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <form class="form form-vertical" action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="name">Nome*</label>
                                            <input type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="Nome do arquivo" autocomplete="off" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="name">Senha*</label>
                                            <input type="password" class="form-control" name="password" placeholder="Senha" autocomplete="off" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="name">Confirmar senha*</label>
                                            <input type="password" class="form-control" name="repassword"
                                                   placeholder="Confirmar senha" autocomplete="off" required>
                                        </div>
                                    </div>
                                </div>
                                @is(['superuser','regiao'])
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="name">Setor</label>
                                            <select class="form-control select2 contractorSelect" name="contractor_id" data-placeholder="">
                                                <option value="0">Nenhuma empreiteira</option>

                                                @foreach($contractors as $contractor)
                                                    <option value="{{$contractor->id}}">{{$contractor->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                @endis
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="name">Tipo de usuário*</label>
                                            @is(['superuser'])
                                            @foreach($roles as $key => $role)
                                                <div>
                                                    <div class="checkbox">
                                                        <input type="checkbox" class="checkbox-input onchangeTipoUser" id="cs_checkbox_{{$key}}" name="role_id[]" value="{{ $key }}">
                                                        <label for="cs_checkbox_{{$key}}">{{ ucfirst($role) }}</label>
                                                    </div>
                                                </div>
                                            @endforeach
                                            @else
                                            @foreach($roles as $key => $role)
                                                @if(!in_array($role,["superuser","operator"]))
                                                    <div>
                                                        <div class="checkbox">
                                                            <input type="checkbox" class="checkbox-input onchangeTipoUser" id="cs_checkbox_{{$key}}" name="role_id[]" value="{{ $key }}">
                                                            <label for="cs_checkbox_{{$key}}">{{ ucfirst($role) }}</label>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach
                                            @endis
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
