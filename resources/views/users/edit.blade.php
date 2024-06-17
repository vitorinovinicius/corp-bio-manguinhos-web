@extends('layouts.frest_template')
@section('css')
    <!-- Select2 -->
    <link rel="stylesheet" href="/bower_components/AdminLTE/plugins/select2/select2.min.css">
@endsection

@section('content-header')
    <div class="content-header-left col-12 mb-2 mt-1">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h5 class="content-header-title float-left pr-1 mb-0">Usuários / Editar #{{$user->id}}</h5>
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb p-0 mb-0">
                        <li class="breadcrumb-item"><i class="bx bx-home-alt"></i> Home</li>
                        <li class="breadcrumb-item">Usuários</li>
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
                    <h3 class="box-title">Dados do usuário</h3>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <form class="form form-vertical" action="{{ route('users.update', $user->uuid) }}" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="_method" value="PUT">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="name">Nome*</label>
                                            <input type="text" class="form-control" name="name" value="{{$user->name}}" placeholder="Nome">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="email">E-mail*</label>
                                            <input type="text" class="form-control" name="email" value="{{$user->email}}" placeholder="E-mail">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="cpf">CPF</label>
                                            <input type="text" class="form-control" name="cpf" value="{{$user->cpf}}" placeholder="CPF">
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label>Tipo de usuário*</label>
                                            @is('superuser')
                                            <div class="form-check">
                                                @foreach ($roles as $key => $role)
                                                    <div>
                                                        <div class="checkbox">
                                                            {{ Form::checkbox('role_id[]', $key, in_array($key, $selectedRoles),["id"=>"role_".$key,"class"=>"checkbox-input"]) }}
                                                            {{ Form::label("role_".$key, ucfirst($role)) }}
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                            @else
                                                @foreach($roles as $key => $role)
                                                    @if(!in_array($role,["superuser","operator"]))
                                                        <div>
                                                            <div class="checkbox">
                                                                {{ Form::checkbox('role_id[]', $key, in_array($key, $selectedRoles),["id"=>"role_".$key,"class"=>"checkbox-input"]) }}
                                                                {{ Form::label("role_".$key, ucfirst($role)) }}
                                                                <br>
                                                            </div>
                                                        </div>
                                                    @endif
                                                @endforeach
                                                @endis
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label>Status</label>
                                            <select class="form-control select2" name="status" id="status" data-placeholder="Selecione um status" required>
                                                <option></option>
                                                <option value="1" {{($user->status == 1)? "selected" : ""}}>Habilitado</option>
                                                <option value="2" {{($user->status != 1)? "selected" : ""}}>Desabilitado</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label>Senha</label>
                                            <p class="">
                                                <a href="{{route('users.change_password',$user->uuid)}}" class="btn btn-warning">Alterar senha</a>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary">Salvar</button>
                                        <a class="btn btn-link  pull-left" href="{{URL::previous()}}"><i class="bx bx-arrow-back"></i> Voltar</a>
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
                placeholder: "Selecione um tipo de usuário",
                allowClear: true
            });

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
