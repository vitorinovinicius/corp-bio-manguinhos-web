@extends('layouts.frest_template')
@section('css')
@endsection

@section('content-header')
    <div class="content-header-left col-12 mb-2 mt-1">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h5 class="content-header-title float-left pr-1 mb-0">Monitoramento</h5>
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb p-0 mb-0">
                        <li class="breadcrumb-item"><i class="bx bx-home-alt"></i> Home</li>
                        <li class="breadcrumb-item">Dashboard</li>
                        <li class="breadcrumb-item active">Monitoramento Empresas</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    @include('error')

    @include('helpers/filter_occurrences_dashboard')
    @include('dashboards.contadores')

    <div class="row">
        <div class="col-12 mt-1 mb-2">
            <h4>Empreiteiras</h4>
            <hr>
            <div class="col-12 mt-1 mb-2">
            @foreach($contractors as $contractor)
                <div class="row">
                    <div class="col-12 mt-1 mb-2">
                        <h4>{{ $contractor->name }}</h4>
                        <hr>
                    </div>
                    <div class="col-md-1 cs-col-md-1 padding-5 padding-tb-5">
                        <a href="{{route("occurrences.index", [Request::getQueryString(),"contractor_id" => $contractor->id])}}">
                            <div class="card text-center">
                                <div class="card-content">
                                    <div class="card-body">
                                        <div class="badge-circle badge-circle-lg badge-circle-light-info mx-auto my-1">
                                            <i class="bx bx-file font-medium-5"></i>
                                        </div>
                                        <p class="text-muted mb-0 line-ellipsis">Total de OS</p>
                                        <h2 class="mb-0 box_emp_total_os" data-total="{{ $contractor->id }}">0</h2>
                                        <div class="progress progress-bar-info mb-1 mt-1">
                                            <div class="progress-bar  progress-bar-animated box_emp_total_progress" role="progressbar" data-progress="{{ $contractor->id }}"></div>
                                        </div>
                                        <span class="progress-description box_emp_total_percent" data-percent="{{ $contractor->id }}">0% fechadas </span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-1 cs-col-md-1 padding-5 padding-tb-5">
                        <a href="{{route('admin.occurrences.closed', [Request::getQueryString(),"contractor_id" => $contractor->id])}}">
                            <div class="card text-center">
                                <div class="card-content">
                                    <div class="card-body">
                                        <div class="badge-circle badge-circle-lg badge-circle-light-success mx-auto my-1">
                                            <i class="bx bx-file font-medium-5"></i>
                                        </div>
                                        <p class="text-muted mb-0 line-ellipsis">Realizadas</p>
                                        <h2 class="mb-0 box_emp_realized_os" data-total-realized="{{ $contractor->id }}">0</h2>
                                        <div class="progress progress-bar-success mb-1 mt-1">
                                            <div class="progress-bar  progress-bar-animated box_emp_realized_progress" role="progressbar" data-progress-realized="{{ $contractor->id }}"></div>
                                        </div>
                                        <span class="progress-description box_emp_realized_percent" data-percent-realized="{{ $contractor->id }}">0% do total </span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-1 cs-col-md-1 padding-5 padding-tb-5">
                        <a href="{{route('admin.occurrences.closed_unsolved', [Request::getQueryString(),"contractor_id" => $contractor->id])}}">
                            <div class="card text-center">
                                <div class="card-content">
                                    <div class="card-body">
                                        <div class="badge-circle badge-circle-lg badge-circle-light-danger mx-auto my-1">
                                            <i class="bx bx-file font-medium-5"></i>
                                        </div>
                                        <p class="text-muted mb-0 line-ellipsis">Não Realizadas</p>
                                        <h2 class="mb-0 box_emp_unsolved_os" data-total-unsolved="{{ $contractor->id }}">0</h2>
                                        <div class="progress progress-bar-danger mb-1 mt-1">
                                            <div class="progress-bar  progress-bar-animated box_emp_unsolved_progress" role="progressbar" data-progress-unsolved="{{ $contractor->id }}"></div>
                                        </div>
                                        <span class="progress-description box_emp_unsolved_percent" data-percent-unsolved="{{ $contractor->id }}">0% do total </span>
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
                                        <h2 class="mb-0 box_emp_inprogress_os" data-total-inprogress="{{ $contractor->id }}">0</h2>
                                        <div class="progress progress-bar-secondary mb-1 mt-1">
                                            <div class="progress-bar  progress-bar-animated box_emp_inprogress_progress" role="progressbar" data-progress-inprogress="{{ $contractor->id }}"></div>
                                        </div>
                                        <span class="progress-description box_emp_inprogress_percent" data-percent-inprogress="{{ $contractor->id }}">0% do total </span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-1 cs-col-md-1 padding-5 padding-tb-5">
                        <a href="{{route('admin.occurrences.pending', [Request::getQueryString(),"contractor_id" => $contractor->id])}}">
                            <div class="card text-center">
                                <div class="card-content">
                                    <div class="card-body">
                                        <div class="badge-circle badge-circle-lg badge-circle-light-warning mx-auto my-1">
                                            <i class="bx bx-file font-medium-5"></i>
                                        </div>
                                        <p class="text-muted mb-0 line-ellipsis">Pendente</p>
                                        <h2 class="mb-0 box_emp_pending_os" data-total-pending="{{ $contractor->id }}">0</h2>
                                        <div class="progress progress-bar-warning mb-1 mt-1">
                                            <div class="progress-bar  progress-bar-animated box_emp_pending_progress" role="progressbar" data-progress-pending="{{ $contractor->id }}"></div>
                                        </div>
                                        <span class="progress-description box_emp_pending_percent" data-percent-pending="{{ $contractor->id }}">0% do total </span>
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
                                        <h2 class="mb-0 box_emp_atribuidos_os" data-total-atribuidos="{{ $contractor->id }}">0</h2>
                                        <div class="progress progress-bar-primary mb-1 mt-1">
                                            <div class="progress-bar  progress-bar-animated box_emp_atribuidos_progress" role="progressbar" data-progress-atribuidos="{{ $contractor->id }}"></div>
                                        </div>
                                        <span class="progress-description box_emp_atribuidos_percent" data-percent-atribuidos="{{ $contractor->id }}">0% do total </span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-1 cs-col-md-1 padding-5 padding-tb-5">
                        <a href="{{route('admin.occurrences.unassigned', [Request::getQueryString(),"contractor_id" => $contractor->id])}}">
                            <div class="card text-center">
                                <div class="card-content">
                                    <div class="card-body">
                                        <div class="badge-circle badge-circle-lg badge-circle-light-primary mx-auto my-1" style="color: #000000 !important;">
                                            <i class="bx bx-file font-medium-5"></i>
                                        </div>
                                        <p class="text-muted mb-0 line-ellipsis">Não Atribuídas</p>
                                        <h2 class="mb-0 box_emp_unassigned_os" data-total-unassigned="{{ $contractor->id }}">0</h2>
                                        <div class="progress progress-bar-primary mb-1 mt-1">
                                            <div class="progress-bar  progress-bar-animated box_emp_unassigned_progress" role="progressbar" style="background-color: #000000; box-shadow: 0 2px 6px 0 rgb(0 0 0);" data-progress-unassigned="{{ $contractor->id }}"></div>
                                        </div>
                                        <span class="progress-description box_emp_unassigned_percent" data-percent-unassigned="{{ $contractor->id }}">0% do total </span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            @endforeach
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script nonce="{{ csp_nonce() }}">

        //Reload da página - fim

        $(function () {

            function contadores_emp(empreiteira) {
                $.ajax({
                    type: 'GET',
                    url: '{!! route('admin.dashboard.ajax',request()->all()) !!}',
                    data: {contractor_id: empreiteira},
                    beforeSend: function () {
                        // $(".box_contador_empreiteiras").append('<div class="overlay"><i class="bx bx-refresh fa-spin"></i></div>');
                    },
                    success: function (data) {
                        $('[data-total="' + empreiteira + '"]').text(data.schedules_all.total);
                        $('[data-progress="' + empreiteira + '"]').css("width", data.schedules_all.progress + '%');
                        $('[data-percent="' + empreiteira + '"]').text(data.schedules_all.percent + "% fechadas");

                        $('[data-total-realized="' + empreiteira + '"]').text(data.schedules_realized.total);
                        $('[data-progress-realized="' + empreiteira + '"]').css("width", data.schedules_realized.progress + '%');
                        $('[data-percent-realized="' + empreiteira + '"]').text(data.schedules_realized.percent + "% do total");

                        $('[ data-total-unsolved="' + empreiteira + '"]').text(data.schedules_unsolved.total);
                        $('[ data-progress-unsolved="' + empreiteira + '"]').css("width", data.schedules_unsolved.progress + '%');
                        $('[ data-percent-unsolved="' + empreiteira + '"]').text(data.schedules_unsolved.percent + "% do total");

                        $('[ data-total-pending="' + empreiteira + '"]').text(data.schedules_pending.total);
                        $('[ data-progress-pending="' + empreiteira + '"]').css("width", data.schedules_pending.progress + '%');
                        $('[ data-percent-pending="' + empreiteira + '"]').text(data.schedules_pending.percent + "% do total");

                        $('[ data-total-inprogress="' + empreiteira + '"]').text(data.schedules_inprogress.total);
                        $('[ data-progress-inprogress="' + empreiteira + '"]').css("width", data.schedules_inprogress.progress + '%');
                        $('[ data-percent-inprogress="' + empreiteira + '"]').text(data.schedules_inprogress.percent + "% do total");

                        $('[ data-total-unassigned="' + empreiteira + '"]').text(data.schedules_unassigned.total);
                        $('[ data-progress-unassigned="' + empreiteira + '"]').css("width", data.schedules_unassigned.progress + '%');
                        $('[ data-percent-unassigned="' + empreiteira + '"]').text(data.schedules_unassigned.percent + "% do total");

                        $('[data-total-atribuidos="' + empreiteira + '"]').text(data.schedules_atribuidos.total);
                        $('[data-progress-atribuidos="' + empreiteira + '"]').css("width", data.schedules_atribuidos.progress);
                        $('[data-percent-atribuidos="' + empreiteira + '"]').text(data.schedules_atribuidos.percent + "% do total");

                    },
                    error: function () {
                        $(".overlay").fadeOut();
                        console.log("Ocorreu um erro inesperado durante o processamento.\nRecarregue a página e tente novamente");
                    }
                });
            }

            var contractors = [];
            // $(".box_contador_empreiteiras").append('<div class="overlay"><i class="bx bx-refresh fa-spin"></i></div>');
            Pace.restart();
            @foreach($contractors as $contractor)
            contadores_emp({{$contractor->id}});
            contractors.push({{$contractor->id}});
            @endforeach

            setInterval(function () {
                $.each(contractors, function (key, value) {
                    contadores_emp(value);
                });
                Pace.restart();
                // $(".box_contador_empreiteiras").append('<div class="overlay"><i class="bx bx-refresh fa-spin"></i></div>');
            }, 1 * 60 * 1000);

        });


    </script>
@endsection
