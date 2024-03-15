@extends('layouts.frest_template')

@section('content-header')
    <div class="content-header-left col-10 mb-2 mt-1">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h5 class="content-header-title float-left pr-1 mb-0">Alertas / Exibir #{{$alert->id}}</h5>
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb p-0 mb-0">
                        <li class="breadcrumb-item"><i class="bx bx-home-alt"></i> Home</li>
                        <li class="breadcrumb-item">Alertas</li>
                        <li class="breadcrumb-item active">Exibir</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    @include('messages')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="box-title">Dados do alerta #{{$alert->id}}</h3>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="name">ID</label>
                                    <p class="form-control-static" >{{$alert->id}}</p>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="name">ID da OS</label>
                                    <p class="form-control-static" >{{$alert->occurrence_id}}</p>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="name">Tipo</label>
                                    <p class="form-control-static" >{{$alert->types()}}</p>
                                </div>
                            </div>
                            @if($alert->user_id)
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="name">Usuário</label>
                                        <p class="form-control-static" >{{optional($alert->user)->name}}</a></p>
                                    </div>
                                </div>
                            @endif
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="name">Detalhamento</label>
                                    <p class="form-control-static" >{{$alert->detail}}</p>
                                </div>
                            </div>
                            @if($alert->treated_detail)
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="name">Tratamento</label>
                                    <p class="form-control-static" >{{$alert->treated_detail}}</p>
                                </div>
                            </div>
                            @endif
                            @if($alert->treated_user_id)
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="name">Tratado por</label>
                                    <p class="form-control-static" ><a href="{{ route("users.show", $alert->treated_user->uuid) }}" target="_blank">{{$alert->treated_user->name}}</a></p>
                                </div>
                            </div>
                            @endif
                            @if($alert->treated_date)
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="name">Tratado em</label>
                                    <p class="form-control-static" >{{$alert->treated_date()}}</p>
                                </div>
                            </div>
                            @endif
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="name">Data da Ocorrência</label>
                                    <p class="form-control-static" >{{$alert->created_at ? date('d/m/Y H:i', strtotime($alert->created_at)) : ''}}</p>
                                </div>
                            </div>
                            @if($alert->occurrence)
                            <div class="col-12">
                                <div class="form-group">
                                    <a href="{{route("occurrences.show", $alert->occurrence->uuid)}}" class="btn btn-xs btn-success" target="_blank"><i class="bx bx-fast-forward"></i> Ir para OS</a>
                                </div>
                            </div>
                            @endif
                        </div>

                        <div class="row">
                            <div class="col-12 d-flex justify-content-end">
                                <a class="btn btn-link pull-left" href="{{ route('alerts.index') }}"><i class="bx bx-fast-forward"></i>  Voltar</a>
                                @shield('alerts.documents_close')
                                @if($alert->treated_date == null)
                                    {{--<a class="btn btn-success pull-right" href="{{ route('alerts.documents_close', $alert->uuid) }}" title="Fechar alerta"><i class="bx bx-ok"></i> Fechar</a>--}}
                                    <button type="button" class="btn btn-success btn-xs pull-right" data-toggle="modal" data-target="#modal-detail">
                                        <i class="bx bx-check"></i> Fechar
                                    </button>
                                    <!-- modal -->
                                    <div class="modal fade" id="modal-detail" tabindex="-1" role="dialog">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header bg-green">
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                    <h4 class="modal-title"><strong>Fechar Alerta #{{$alert->id}}</strong></h4>
                                                </div>
                                                <form name="form-detail" action="{{ route('alerts.documents_close', $alert->uuid) }}" method="POST">
                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                    <input type="hidden" name="_method" value="PUT">
                                                    <div class="modal-body">
                                                        {{--<input type="hidden" name="redirect_type" value="1">--}}
                                                        <div class="form-group">
                                                            <label for="treated_detail">Detalhes do Tratamento*</label>
                                                            <div><textarea class="form-control" name="treated_detail" minlength="5" cols="100" required>{{ old('treated_detail') }}</textarea></div>
                                                        </div>
                                                        <br><br>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
                                                        <button type="submit" class="btn btn-success" onClick="document.form-detail.submit()">Confirmar</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                @endshield
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
