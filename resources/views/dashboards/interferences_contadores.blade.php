@if($interferences_all)
    <style>
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
            <h4> <strong>Monitoramento das Interferências: </strong>{{ app('request')->exists('scheduled_date') == false ? "Hoje" :  app('request')->input('scheduled_date') }}</h4>
            <hr>
        </div>
    </div>
    <div class="row">
        @foreach($interferences_all as $interference)
            <div class="col-md-3 col_interference_{{$interference->id}}"  title="{{ $interference->description }}">
                <a href="{{ route('interferences.relatorio.show', [$interference->uuid,Request::getQueryString()]) }}" target="_blank">
                    <div class="card text-center">
                        <div class="card-content">
                            <div class="card-body">
                                <p class="text-muted mb-0 label-primary box_nome_interferencia_{{$interference->id}}">{{ $interference->description }}</p>
                                <h2 class="mb-0 box_total_os_{{$interference->id}}">0</h2>
                                <div class="progress progress-bar-info mb-1 mt-1">
                                    <div class="progress-bar  progress-bar-animated box_total_progress_{{$interference->id}}" role="progressbar"></div>
                                </div>
                                <span class="progress-description box_total_percent_{{$interference->id}}">0% </span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        @endforeach
    </div>

    @section('scripts_extra')
        <script>
            $(function () {
                function contadores() {
                    $.ajax({
                        type: 'GET',
                        url: '{!! route('interferences.dashboard.ajax',request()->all()) !!}',
                        beforeSend: function () {
                            // $(".box_contador").append('<div class="overlay"><i class="bx bx-refresh fa-spin"></i></div>');
                            Pace.restart();
                        },
                        success: function (data) {
                            // console.log(data.data.interferences);
                            data.data.interferences.forEach(function (index) {
                                $(".box_nome_interferencia_" + index.id).text(index.description);
                                $(".box_total_os_" + index.id).text(index.total);
                                $(".box_total_progress_" + index.id).css("width", index.percent + '%');
                                $(".box_total_percent_" + index.id).text(index.percent + "%");
                            });

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
@endif
