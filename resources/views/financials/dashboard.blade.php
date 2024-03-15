@extends('layouts.frest_template')

@section('content-header')
    <div class="content-header-left col-12 mb-2 mt-1">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h5 class="content-header-title float-left pr-1 mb-0">Conclusão - Monitoramento</h5>
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb p-0 mb-0">
                        <li class="breadcrumb-item"><i class="bx bx-home-alt"></i> Home</li>
                        <li class="breadcrumb-item">Conclusão</li>
                        <li class="breadcrumb-item active">Monitoramento</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    @include('error')
    @include('helpers/filter_occurrences_dashboard')

    <div class="row">
        <div class="col-12 mt-1 mb-2">
            <h4>Contadores</h4>
            <hr>
        </div>
    </div>

    <div class="row">
        <div class="col-md-2 offset-md-1 padding-5 padding-tb-5">
            <div class="card text-center">
                <div class="card-content">
                    <div class="card-body">
                        <div class="badge-circle badge-circle-lg badge-circle-light-primary mx-auto my-1">
                            <i class="bx bx-money font-medium-5"></i>
                        </div>
                        <p class="text-muted mb-0 line-ellipsis">Pendentes de aprovação</p>
                        <h2 class="mb-0 pendings">0</h2>
                        <br>
                        <a href="{{ route('admin.occurrences.to_approved') }}" class="small-box-footer" target="_blank">Mais informações</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-2 cs-col-md-2 padding-5 padding-tb-5">
            <div class="card text-center">
                <div class="card-content">
                    <div class="card-body">
                        <div class="badge-circle badge-circle-lg badge-circle-light-success mx-auto my-1">
                            <i class="bx bx-check-circle font-medium-5"></i>
                        </div>
                        <p class="text-muted mb-0 line-ellipsis">Aprovados</p>
                        <h2 class="mb-0 completeds">0</h2>
                        <br>
                        <a href="{{ route('admin.occurrences.approved') }}" class="small-box-footer" target="_blank">Mais informações</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-2 cs-col-md-2 padding-5 padding-tb-5">
            <div class="card text-center">
                <div class="card-content">
                    <div class="card-body">
                        <div class="badge-circle badge-circle-lg badge-circle-light-warning mx-auto my-1">
                            <i class="bx bx-bug font-medium-5"></i>
                        </div>
                        <p class="text-muted mb-0 line-ellipsis">Para Empresa ajustar</p>
                        <h2 class="mb-0 toAdjust">0</h2>
                        <br>
                        <a href="{{ route('admin.occurrences.to_adjust') }}" class="small-box-footer" target="_blank">Mais informações</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-2 cs-col-md-2 padding-5 padding-tb-5">
            <div class="card text-center">
                <div class="card-content">
                    <div class="card-body">
                        <div class="badge-circle badge-circle-lg badge-circle-light-info mx-auto my-1">
                            <i class="bx bx-plus-medical font-medium-5"></i>
                        </div>
                        <p class="text-muted mb-0 line-ellipsis">Ajuste feito pela Empresa</p>
                        <h2 class="mb-0 toAdjustOk">0</h2>
                        <br>
                        <a href="{{ route('admin.occurrences.adjusted') }}" class="small-box-footer" target="_blank">Mais informações</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-2 cs-col-md-2 padding-5 padding-tb-5">
            <div class="card text-center">
                <div class="card-content">
                    <div class="card-body">
                        <div class="badge-circle badge-circle-lg badge-circle-light-danger mx-auto my-1">
                            <i class="bx bx-sad font-medium-5"></i>
                        </div>
                        <p class="text-muted mb-0 line-ellipsis">Reprovados</p>
                        <h2 class="mb-0 reproveds">0</h2>
                        <br>
                        <a href="{{ route('admin.occurrences.disapproved') }}" class="small-box-footer" target="_blank">Mais informações</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="box-title">Serviços finalizados {{ app('request')->input('scheduled_date') ? " entre: " . app('request')->input('scheduled_date') : "do dia: ". date("d/m/Y")  }}</h3>
                </div>
                @include('occurrences.helpers.list_default')
            </div>
        </div>
    </div>

@endsection
@section('scripts')
    <script nonce="{{ csp_nonce() }}">
        $(function () {
            function contadores() {
                $.ajax({
                    type: 'GET',
                    url: '{!! route('financials.dashboard.ajax',request()->all()) !!}',
                    beforeSend: function () {
                        $(".box_contador").append('<div class="overlay"><i class="bx bx-refresh fa-spin"></i></div>');
                    },
                    success: function (data) {
                        $(".completeds").text(data.completeds);
                        $(".reproveds").text(data.reproveds);
                        $(".pendings").text(data.pendings);
                        $(".toAdjust").text(data.toAdjust);
                        $(".toAdjustOk").text(data.toAdjustOk);

                        $(".overlay").fadeOut();

                    },
                    error: function () {
                        $(".overlay").fadeOut();
                        console.log("Ocorreu um erro inesperado durante o processamento.\nRecarregue a página e tente novamente");
                    }
                });
            }

            contadores();
            setInterval(function () {
                contadores();
            }, 2 * 60 * 1000);
        });

    </script>

@endsection
