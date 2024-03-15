<style nonce="{{ csp_nonce() }}">
    @media (min-width: 992px) {
        .cs-col-md-1 {
            max-width: 14.28% !important;
            width: 14.28% !important;
            flex: 0 0 14.28%;
        }
    }

    .padding-tb-5 {
        padding-top: 5px;
        padding-bottom: 5px;
    }

</style>
<div class="row">
    <div class="col-md-12 d-flex justify-content-between">
        <h4>Monitoramento das Tickets</h4>
        @is('cliente')
            <a class="btn btn-primary" href="{{route('ticket.create')}}" role="button">Novo ticket</a>
        @endis
    </div>

</div>
<hr>
<div class="row d-flex justify-content-center">
        <div class="col-md-1 cs-col-md-1 padding-5 padding-tb-5">
            <a href="{{route("occurrences.index",Request::getQueryString())}}">
                <div class="card text-center">
                    <div class="card-content">
                        <div class="card-body">
                            <div class="badge-circle badge-circle-lg badge-circle-light-info mx-auto my-1">
                                <i class="bx bx-file font-medium-5"></i>
                            </div>
                            <p class="text-muted mb-0 line-ellipsis">Total de Tikets</p>
                            <h2 class="mb-0 box_total_tikets">0</h2>
                            <div class="progress progress-bar-info mb-1 mt-1">
                                <div class="progress-bar  progress-bar-animated box_total_progress" role="progressbar"></div>
                            </div>
                            <span class="progress-description box_total_percent">0% fechados </span>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-1 cs-col-md-1 padding-5 padding-tb-5">
            <a href="{{route('admin.occurrences.closed',Request::getQueryString())}}">
                <div class="card text-center">
                    <div class="card-content">
                        <div class="card-body">
                            <div class="badge-circle badge-circle-lg badge-circle-light-success mx-auto my-1">
                                <i class="bx bx-file font-medium-5"></i>
                            </div>
                            <p class="text-muted mb-0 line-ellipsis">Realizadas</p>
                            <h2 class="mb-0 box_realized_tikets">0</h2>
                            <div class="progress progress-bar-success mb-1 mt-1">
                                <div class="progress-bar  progress-bar-animated box_realized_progress" role="progressbar"></div>
                            </div>
                            <span class="progress-description box_realized_percent">0% do total </span>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-1 cs-col-md-1 padding-5 padding-tb-5">
            <a href="{{route('admin.occurrences.closed_unsolved',Request::getQueryString())}}">
                <div class="card text-center">
                    <div class="card-content">
                        <div class="card-body">
                            <div class="badge-circle badge-circle-lg badge-circle-light-danger mx-auto my-1">
                                <i class="bx bx-file font-medium-5"></i>
                            </div>
                            <p class="text-muted mb-0 line-ellipsis">Cancelados</p>
                            <h2 class="mb-0 box_canceled_tikets">0</h2>
                            <div class="progress progress-bar-danger mb-1 mt-1">
                                <div class="progress-bar  progress-bar-animated box_canceled_progress" role="progressbar"></div>
                            </div>
                            <span class="progress-description box_canceled_percent">0% do total </span>
                        </div>
                    </div>
                </div>
            </a>
        </div>
</div>

@section('scripts_extra')
    <script nonce="{{ csp_nonce() }}">
        $(function () {
            function contadores() {
                $.ajax({
                    type: 'GET',
                    url: '{!! route('admin.dashboard_tikets.ajax',request()->all()) !!}',
                    beforeSend: function () {
                        // $(".box_contador").append('<div class="overlay"><i class="bx bx-refresh fa-spin"></i></div>');
                        Pace.restart();
                    },
                    success: function (data) {
                        $(".box_total_tikets").text(data.tikets_all.total);
                        $(".box_total_progress").css("width", data.tikets_all.progress + '%');
                        $(".box_total_percent").text(data.tikets_all.percent + "% fechadas");

                        $(".box_realized_tikets").text(data.tikets_realized.total);
                        $(".box_realized_progress").css("width", data.tikets_realized.progress + '%');
                        $(".box_realized_percent").text(data.tikets_realized.percent + "% do total");

                        $(".box_canceled_tikets").text(data.tikets_canceled.total);
                        $(".box_canceled_progress").css("width", data.tikets_canceled.progress + '%');
                        $(".box_canceled_percent").text(data.tikets_canceled.percent + "% do total");

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
            }, 1 * 60 * 1000);
        });

    </script>
@endsection
