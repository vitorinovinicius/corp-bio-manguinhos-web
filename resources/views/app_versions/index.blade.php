@extends('layouts.frest_template')

@section('content-header')
    <div class="content-header-left col-10 mb-2 mt-1">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h5 class="content-header-title float-left pr-1 mb-0">Versões do Aplicativo</h5>
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb p-0 mb-0">
                        <li class="breadcrumb-item"><i class="bx bx-home-alt"></i> Home</li>
                        <li class="breadcrumb-item active">Versões do Aplicativo</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    @is("superuser")
    <div class="col-2 d-flex justify-content-end align-items-center">
        <a class="btn btn-success pull-right" href="{{ route('app_versions.create') }}"><i class="bx bx-plus"></i> Novo</a>
    </div>
    @endis
@endsection

@section('content')

    @include('messages')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        @if($app_versions->count())
                            <div class="table-responsive">
                                <table class="table table-condensed table-striped table-sm table-hover">
                                    <thead>
                                    <tr>
                                        @is('superuser')
                                        <th>Id</th>
                                        @endis
                                        <th>Nome Versão</th>
                                        <th>Código Versão</th>
                                        @is('superuser')
                                        <th>Data de Cadastro</th>
                                        @endis
                                        <th class="text-right">OPÇÕES</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($app_versions as $app_version)
                                        <tr>
                                            @is('superuser')
                                            <td>{{$app_version->id}}</td>
                                            @endis
                                            <td>{{$app_version->version_name}}</td>
                                            <td>{{$app_version->version_code}}</td>
                                            @is('superuser')
                                            <td>{{Carbon\Carbon::parse($app_version->created_at)->format('d/m/Y H:i')}}</td>
                                            @endis

                                            <td class="text-right">
                                                <button type="button" class="btn btn-icon btn-xs btn-information btn-info" data-toggle="modal" data-target="#modal-information"
                                                        data-version-name="{{$app_version->version_name}}"
                                                        data-version-code="{{$app_version->version_code}}"
                                                        data-description="{{$app_version->description}}"
                                                        data-toggle="tooltip" title="Informações"
                                                >
                                                    <i class="bx bx-info-circle"></i> Informações
                                                </button>
                                                @if($app_version->status == 1)
                                                    <a href="{{$app_version->apk_url}}" class="btn btn-icon btn-sm btn-primary" target="_blank"><i class='bx bx-download'></i> Baixar Aplicativo</a>
                                                @endif
                                                @is("superuser")
                                                @if($app_version->status)
                                                    <a class="btn btn-danger btn-xs " href="{{ route('app_versions.status',[$app_version->uuid,'status'=>0]) }}"><i class="bx bx-check"></i> Desativar</a>
                                                @else
                                                    <a class="btn btn-success btn-xs " href="{{ route('app_versions.status',[$app_version->uuid,'status'=>1]) }}"><i class="bx bx-check"></i> Liberar</a>
                                                @endif

                                                <form action="{{ route('app_versions.destroy', $app_version->uuid) }}" method="POST" style="display: inline;" onsubmit="if(confirm('Deletar? Você tem certeza?')) { return true } else {return false };">
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                    <button type="submit" class="btn btn-xs btn-danger">
                                                        <i class="bx bx-trash"></i> Delete
                                                    </button>
                                                </form>
                                                @endis
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            {!! $app_versions->render() !!}
                        @else
                            <h4 class="text-center alert alert-info">Não há registros a serem exibidos!</h4>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

<div class="modal fade" id="modal-information">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Informações do app</h4>
            </div>
            <div class="modal-body">

                <div class="row">
                    <div class="form-group col-md-6">
                        <label>Nome versão</label>
                        <div class="input-static" id="version-name"></div>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Código versão</label>
                        <div class="input-static" id="version-code" style="white-space: pre-wrap">-</div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-12">
                        <label>Descrição</label>
                        <div class="input-static" id="description" style="white-space: pre-wrap">-</div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-right" data-dismiss="modal">Fechar</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

@section('scripts_extra')
    <script nonce="{{ csp_nonce() }}">
        $(function () {
            $(".btn-information").on("click", function () {
                $("#version-name").text($(this).data("versionName"));
                $("#version-code").text($(this).data("versionCode"));
                $("#description").text($(this).data("description"));
            });
        });
    </script>
@endsection
