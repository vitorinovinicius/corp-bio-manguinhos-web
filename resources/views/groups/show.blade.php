@extends('layouts.frest_template')

@section('content-header')
    <div class="content-header-left col-10 mb-2 mt-1">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h5 class="content-header-title float-left pr-1 mb-0">Grupo / Exibir #{{$group->id}}</h5>
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb p-0 mb-0">
                        <li class="breadcrumb-item"><i class="bx bx-home-alt"></i> Home</li>
                        <li class="breadcrumb-item">Grupo</li>
                        <li class="breadcrumb-item active">Exibir</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="col-2 d-flex justify-content-end align-items-center">
        <form action="{{ route('groups.destroy', $group->uuid) }}" method="POST" style="display: inline;" onsubmit="if(confirm('Deseja realmente excluir esse item?')) { return true } else {return false };">
            <input type="hidden" name="_method" value="DELETE">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="btn-group pull-right" role="group" aria-label="...">
                @shield('group.edit')
                <a class="btn btn-warning btn-group" role="group" href="{{ route('groups.edit', $group->uuid) }}"><i class="bx bx-edit"></i> Editar</a>
                @endshield
                @shield('group.destroy')
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
                    <h3 class="box-title">Dados do grupo</h3>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-1">
                                <div class="form-group">
                                    <label for="name">ID</label>
                                    <p class="form-control-static" >{{$group->id}}</p>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label for="name">Nome</label>
                                    <p class="form-control-static" >{{$group->name}}</p>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label for="type">Descrição</label>
                                    <p class="form-control-static" >{{$group->description}}</p>
                                </div>
                            </div>
                           
                            @if((Auth::user()->name) == "Superuser")
                            <div class="col-2">
                                <div class="form-group">
                                    <label for="name">Empreiteira</label>
                                    <p class="form-control-static" >{{optional($group->contractor)->name}}</p>
                                </div>
                            </div>
                            @endif
                        </div>
                        {{-- todo:: Exibir client e participantes do grupo --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('groups.includes.users')
    @include('groups.includes.occurrence_clients')
    @include('groups.includes.ticket_type')
@endsection

@section('scripts')
    <!-- Select2 -->
    <script src="/bower_components/AdminLTE/plugins/select2/select2.full.min.js"></script>
    <script nonce="{{ csp_nonce() }}">
        $(function () {
            
            $(document).on('click', '#check_all_clients', function () {
                if ($(this).prop('checked')) {
                    $('.ids_check_clients').prop('checked', true);
                } else {
                    $('.ids_check_clients').prop('checked', false);
                }
            });
            
            $(document).on('click', '#btn-attr-occurrence-client', function (e) {
                e.preventDefault();
                
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                var ids = [];
                $.each($('.tb-occurrence-clients tbody :checked'), function (i, v) {
                    ids.push($(v).val())
                });
                if (ids.length == 0) {
                    alert('Selecione pelo menos um item');
                } else {
                    jQuery.ajax({
                        type: 'POST',
                        url: '{!!  route('users.desassociate.occurrence_clients.store', [$group->uuid]) !!} ',
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

            $(document).on('click', '#check_all_users', function () {
                if ($(this).prop('checked')) {
                    $('.ids_check_users').prop('checked', true);
                } else {
                    $('.ids_check_users').prop('checked', false);
                }
            });

            $(document).on('click', '#btn-attr-user', function (e) {
                e.preventDefault();
                
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                var ids = [];
                $.each($('.tb-users tbody :checked'), function (i, v) {
                    ids.push($(v).val())
                });
                if (ids.length == 0) {
                    alert('Selecione pelo menos um item');
                } else {
                    jQuery.ajax({
                        type: 'POST',
                        url: '{!!  route('users.desassociate.store', [$group->uuid]) !!} ',
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
        });        
        
    </script>
@endsection
