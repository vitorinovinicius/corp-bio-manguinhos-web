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
    <div class="col-12 mt-1 mb-2">
        <h4>Monitoramento das Ocorrências do dia</h4>
        <hr>
    </div>
</div>
<div class="row">
    <div class="col-md-1 cs-col-md-1 padding-5 padding-tb-5">
        <a href="{{route("occurrences.index",Request::getQueryString())}}">
            <div class="card text-center">
                <div class="card-content">
                    <div class="card-body">
                        <div class="badge-circle badge-circle-lg badge-circle-light-info mx-auto my-1">
                            <i class="bx bx-file font-medium-5"></i>
                        </div>
                        <p class="text-muted mb-0 line-ellipsis">Total de OS</p>
                        <h2 class="mb-0 box_total_os">0</h2>
                        <div class="progress progress-bar-info mb-1 mt-1">
                            <div class="progress-bar  progress-bar-animated box_total_progress" role="progressbar"></div>
                        </div>
                        <span class="progress-description box_total_percent">0% fechadas </span>
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
                        <h2 class="mb-0 box_realized_os">0</h2>
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
                        <p class="text-muted mb-0 line-ellipsis">Não Realizadas</p>
                        <h2 class="mb-0 box_unsolved_os">0</h2>
                        <div class="progress progress-bar-danger mb-1 mt-1">
                            <div class="progress-bar  progress-bar-animated box_unsolved_progress" role="progressbar"></div>
                        </div>
                        <span class="progress-description box_unsolved_percent">0% do total </span>
                    </div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-1 cs-col-md-1 padding-5 padding-tb-5">
        <a href="#">
            <div class="card text-center">
                <div class="card-content">
                    <div class="card-body">
                        <div class="badge-circle badge-circle-lg badge-circle-light-secondary mx-auto my-1">
                            <i class="bx bx-file font-medium-5"></i>
                        </div>
                        <p class="text-muted mb-0 line-ellipsis">Em Andamento</p>
                        <h2 class="mb-0 box_inprogress_os">0</h2>
                        <div class="progress progress-bar-secondary mb-1 mt-1">
                            <div class="progress-bar  progress-bar-animated box_inprogress_progress" role="progressbar"></div>
                        </div>
                        <span class="progress-description box_inprogress_percent">0% do total </span>
                    </div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-1 cs-col-md-1 padding-5 padding-tb-5">
        <a href="{{route('admin.occurrences.pending',Request::getQueryString())}}">
            <div class="card text-center">
                <div class="card-content">
                    <div class="card-body">
                        <div class="badge-circle badge-circle-lg badge-circle-light-warning mx-auto my-1">
                            <i class="bx bx-file font-medium-5"></i>
                        </div>
                        <p class="text-muted mb-0 line-ellipsis">Pendentes</p>
                        <h2 class="mb-0 box_pending_os">0</h2>
                        <div class="progress progress-bar-warning mb-1 mt-1">
                            <div class="progress-bar  progress-bar-animated box_pending_progress" role="progressbar"></div>
                        </div>
                        <span class="progress-description box_pending_percent">0% do total </span>
                    </div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-1 cs-col-md-1 padding-5 padding-tb-5">
        <a href="#">
            <div class="card text-center">
                <div class="card-content">
                    <div class="card-body">
                        <div class="badge-circle badge-circle-lg badge-circle-light-primary mx-auto my-1">
                            <i class="bx bx-file font-medium-5"></i>
                        </div>
                        <p class="text-muted mb-0 line-ellipsis">Atribuídas</p>
                        <h2 class="mb-0 box_atribuidos_os">0</h2>
                        <div class="progress progress-bar-primary mb-1 mt-1">
                            <div class="progress-bar  progress-bar-animated box_atribuidos_progress" role="progressbar"></div>
                        </div>
                        <span class="progress-description box_atribuidos_percent">0% do total </span>
                    </div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-1 cs-col-md-1 padding-5 padding-tb-5">
        <a href="{{route('admin.occurrences.unassigned',Request::getQueryString())}}">
            <div class="card text-center">
                <div class="card-content">
                    <div class="card-body">
                        <div class="badge-circle badge-circle-lg badge-circle-light-primary mx-auto my-1" style="color: #000000 !important;">
                            <i class="bx bx-file font-medium-5"></i>
                        </div>
                        <p class="text-muted mb-0 line-ellipsis">Não Atribuídas</p>
                        <h2 class="mb-0 box_unassigned_os">0</h2>
                        <div class="progress progress-bar-primary mb-1 mt-1">
                            <div class="progress-bar  progress-bar-animated box_unassigned_progress" role="progressbar" style="background-color: #000000; box-shadow: 0 2px 6px 0 rgb(0 0 0 / 60%);"></div>
                        </div>
                        <span class="progress-description box_unassigned_percent">0% do total </span>
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
                    url: '{!! route('admin.dashboard.ajax',request()->all()) !!}',
                    beforeSend: function () {
                        // $(".box_contador").append('<div class="overlay"><i class="bx bx-refresh fa-spin"></i></div>');
                        Pace.restart();
                    },
                    success: function (data) {
                        $(".box_total_os").text(data.schedules_all.total);
                        $(".box_total_progress").css("width", data.schedules_all.progress + '%');
                        $(".box_total_percent").text(data.schedules_all.percent + "% fechadas");

                        $(".box_realized_os").text(data.schedules_realized.total);
                        $(".box_realized_progress").css("width", data.schedules_realized.progress + '%');
                        $(".box_realized_percent").text(data.schedules_realized.percent + "% do total");

                        $(".box_unsolved_os").text(data.schedules_unsolved.total);
                        $(".box_unsolved_progress").css("width", data.schedules_unsolved.progress + '%');
                        $(".box_unsolved_percent").text(data.schedules_unsolved.percent + "% do total");

                        $(".box_pending_os").text(data.schedules_pending.total);
                        $(".box_pending_progress").css("width", data.schedules_pending.progress + '%');
                        $(".box_pending_percent").text(data.schedules_pending.percent + "% do total");

                        $(".box_inprogress_os").text(data.schedules_inprogress.total);
                        $(".box_inprogress_progress").css("width", data.schedules_inprogress.progress + '%');
                        $(".box_inprogress_percent").text(data.schedules_inprogress.percent + "% do total");


                        $(".box_unassigned_os").text(data.schedules_unassigned.total);
                        $(".box_unassigned_progress").css("width", data.schedules_unassigned.progress + '%');
                        $(".box_unassigned_percent").text(data.schedules_unassigned.percent + "% do total");

                        $(".box_atribuidos_os").text(data.schedules_atribuidos.total);
                        $(".box_atribuidos_progress").css("width", data.schedules_atribuidos.progress + '%');
                        $(".box_atribuidos_percent").text(data.schedules_atribuidos.percent + "% do total");

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
