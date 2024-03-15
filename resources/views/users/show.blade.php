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
                    <button type="submit" class="btn btn-danger">Excluir <i class="bx bx-trash"></i></button>
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
                        @if($user->contractor)
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="name">Empreiteira</label>
                                        <p class="form-control-static">{{$user->contractor->name}}</p>
                                    </div>
                                </div>
                            </div>
                        @endif
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="name">Tipo de Usuário</label>
                                    <p class="form-control-static">
                                        <span class="badge bg-blue">{{ $user->roles->implode("name", " | ") }}</span>
                                    </p>
                                </div>
                            </div>
                        </div>                       
                        @if(count($user->regions()->get()))
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="name">Região</label>
                                        <p class="form-control-static">{{$user->regions()->get()->implode('name', ', ')}}</p>
                                    </div>
                                </div>
                            </div>
                        @endif
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
                                        <p class="form-control-static">
                                            <a href="{{route('users.change_password',$user->uuid)}}" class="btn btn-warning">Alterar senha</a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endif
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="name">Assinatura</label>
                                    @if($user->signature)
                                        <img src="{{$user->signature}}" class="h-100 w-100 rounded-left img-assinatura">
                                    @else
                                        <p class="form-control-static"> Não há assinatura cadastrada </p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if(!$user->hasRole('cliente'))
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="box-title">Equipes</h3>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <table class="table table-condensed table-striped table-sm table-hover">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nome</th>
                                <th>Supervisor</th>

                                <th>Criado</th>
                                <th>Modificado</th>

                                <th class="text-right">OPÇÕES</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach($teams as $team)
                                <tr>
                                    <td>{{$team->id}}</td>
                                    <td>{{$team->name}}</td>
                                    <td>{{ optional($team->users()->wherePivot('is_supervisor',1)->first())->name }}</td>
                                    <td>{{ date('d/m/Y H:i:s', strtotime($team->created_at)) }}</td>
                                    <td>{{ date('d/m/Y H:i:s', strtotime($team->updated_at)) }}</td>

                                    <td class="text-right">
                                        @is(['admin','superuser'])
                                        <a href="{{ route('teams.show', $team->uuid) }}" class="btn btn-icon btn-sm btn-primary" data-toggle="tooltip" data-placement="left" title="Exibir"><i class="bx bx-book-open"></i></a>
                                        @endis
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            {!! $teams->render() !!}
        </div>
    </div>
    @endif
    @if($user->hasRole('cliente'))
        @include("users.groups.groups")
    @endif

    <a class="btn btn-primary" href="{{ route('users.index') }}"><i class="bx bx-arrow-back"></i> Voltar</a>

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

            $(document).on('click', '#btn-attr-group', function (e) {
                e.preventDefault();
                
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                var ids = [];
                $.each($('.tb-groups tbody :checked'), function (i, v) {
                    ids.push($(v).val())
                });
                if (ids.length == 0) {
                    alert('Selecione pelo menos um item');
                } else {
                    jQuery.ajax({
                        type: 'POST',
                        url: '{!!  route('groups.desassociate.store', [$user->uuid]) !!} ',
                        data: "ids=" + ids,

                        success: function (data) {
                            console.log(data);
                            if (data.retorno = 1) {
                                alert(data.mensagem);
                                location.reload(true);
                            } else {
                                alert("Ocorreu algum erro, tente novamente a operação \n " + data.mensagem);
                                // location.reload();
                            }
                        },
                        error: function () {
                            alert("Ocorreu um erro inesperado durante o processamento!\n Recarrege a página e tente novamente.");
                        }
                    });
                }
            });
        })
    </script>
@endsection
