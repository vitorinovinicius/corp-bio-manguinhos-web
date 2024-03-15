@extends('layouts.frest_template')

@section('content-header')
    <div class="content-header-left col-10 mb-2 mt-1">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h5 class="content-header-title float-left pr-1 mb-0">Perfil (Regras) / Exibir #{{$role->id}}</h5>
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb p-0 mb-0">
                        <li class="breadcrumb-item"><i class="bx bx-home-alt"></i> Home</li>
                        <li class="breadcrumb-item">Perfil (Regras)</li>
                        <li class="breadcrumb-item active">Exibir</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="col-2 d-flex justify-content-end align-items-center">
        <form action="{{ route('roles.destroy', $role->id) }}" method="POST" style="display: inline;" onsubmit="if(confirm('Deseja realmente excluir esse item?')) { return true } else {return false };">
            <input type="hidden" name="_method" value="DELETE">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="btn-group pull-right" role="group" aria-label="...">
                <a class="btn btn-warning btn-group" role="group" href="{{ route('roles.edit', $role->id) }}"><i class="bx bx-edit"></i> Editar</a>
                <button type="submit" class="btn btn-danger">Excluir <i class="bx bx-trash"></i></button>
            </div>
        </form>
    </div>
@endsection

@section('content')
    @include('messages')
    @include('error')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="box-title">Dados do Perfil (Regras)</h3>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="name">Nome</label>
                                    <p class="form-control-static" >{{$role->name}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="box-title">Permissões do Grupo {{$role->name}}</h3>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <form class="form form-vertical" action="{{ route('roles.permission.update',$role->id) }}" method="POST">
                            <input type="hidden" name="_method" value="PUT">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="table-responsive">
                                            <table class="table table-condensed table-striped table-sm table-hover">
                                                <thead>
                                                <tr>
                                                    <th>Nome</th>

                                                    <th>Descrição</th>
                                                    <th>Tem acesso?</th>
                                                </tr>
                                                </thead>

                                                <tbody>
                                                @foreach($permissions as $permission)
                                                    <tr>
                                                        <td>{{$permission->name}}</td>
                                                        <td>{{$permission->readable_name}}</td>
                                                        <td>
                                                            <input type="radio" value="1" name="{{$permission->id}}" {{(roleHasPermission($role->id,$permission->id) == 1)? "checked": ""}} required> Sim
                                                            <input type="radio" value="0" name="{{$permission->id}}" {{(roleHasPermission($role->id,$permission->id) == 2)? "checked": ""}} required> Não
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12 d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary">Atualizar</button>
                                        <a class="btn btn-link pull-right"
                                           href="{{ route('roles.index') }}"><i
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
