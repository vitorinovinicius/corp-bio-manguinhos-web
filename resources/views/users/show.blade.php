@extends('layouts.frest_template')

@section('content-header')
    <div class="content-header-left col-10 mb-2 mt-1">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h5 class="content-header-title float-left pr-1 mb-0">Usuários / Exibir #{{$user->id}}</h5>
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb p-0 mb-0">
                        <li class="breadcrumb-item"><i class="bx bx-home-alt"></i> Home</li>
                        <li class="breadcrumb-item">Usuários</li>
                        <li class="breadcrumb-item active">Exibir</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="col-2 d-flex justify-content-end align-items-center">
        <form action="{{ route('users.destroy', $user->uuid) }}" method="POST" style="display: inline;" onsubmit="if(confirm('Deseja realmente excluir esse item?')) { return true } else {return false };">
            <input type="hidden" name="_method" value="DELETE">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            @if(!$user->hasRole('superuser') OR $user->hasRole('superuser') && \Defender::hasRole('superuser'))
                <div class="btn-group pull-right" role="group" aria-label="...">
                    @shield('users.edit')
                    <a class="btn btn-warning btn-group" role="group" href="{{ route('users.edit', $user->uuid) }}"><i class="bx bx-edit"></i> Editar</a>
                    @endshield
                    @shield('users.destroy')
                    <button type="submit" class="btn btn-danger btn-group" role="group">Excluir <i class="bx bx-trash"></i></button>
                    @endshield
                </div>
            @endif
        </form>
    </div>
@endsection

@section('content')
    @include('messages')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="box-title">Dados do usuário</h3>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="name">ID</label>
                                    <p class="form-control-static">{{$user->id}}</p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="name">Nome</label>
                                    <p class="form-control-static">{{$user->name}}</p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="name">E-mail</label>
                                    <p class="form-control-static">{{$user->email}}</p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="name">CPF</label>
                                    <p class="form-control-static">{{$user->cpf}}</p>
                                </div>
                            </div>
                        </div>
                        @if($setores->count())
                            @foreach($setores as $setor)
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="name">Setor</label>
                                        <p class="form-control-static">{{$setor->name}}</p>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        @endif
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="name">Tipo de Usuário</label>
                                    <p>
                                        <span class="badge bg-blue">{{ $user->roles->implode("name", " | ") }}</span>
                                    </p>
                                </div>
                            </div>
                        </div>      
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="name">Status</label>
                                    <p class="form-control-static">{{($user->status == 1)? "Habilitado" : "Desabilitado"}}</p>
                                </div>
                            </div>
                        </div>
                        @if(!$user->roles->contains('id',1))
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="name">Senha</label>
                                        <p>
                                            <a href="{{route('users.change_password',$user->uuid)}}" class="btn btn-warning">Alterar senha</a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-12 d-flex justify-content-end">
                                <a class="btn btn-link  pull-left" href="{{URL::previous()}}"><i class="bx bx-arrow-back"></i> Voltar</a>
                            </div>
                        </div>
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
            $(document).on('click', '#check_all_groups', function () {
                if ($(this).prop('checked')) {
                    $('.ids_check_groups').prop('checked', true);
                } else {
                    $('.ids_check_groups').prop('checked', false);
                }
            });
        })
    </script>
@endsection
