@extends('layouts.frest_template')
@section('css')
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/css/pickers/daterange/daterangepicker.css')}}">
    @if(env('TIPO_MAPA') == 'LEAFLETJS')
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css"
              integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ=="
              crossorigin=""/>
        <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.css"/>
    @endif
    <style nonce="{{ csp_nonce() }}">
        .grabbable {
            cursor: grab;
        }

        .grabbable:active {
            cursor: grabbing;
        }

        p.form-control {
            text-transform: uppercase;
        }

        #mapRoteiro, #map {
            height: 0;
            overflow: hidden;
            padding-bottom: 22.25%;
            padding-top: 222px;
            position: relative;
        }
    </style>
@endsection
{{-- vendor styles --}}
@section('vendor-styles')
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/css/extensions/toastr.css')}}">
@endsection

{{-- page styles --}}
@section('page-styles')
    <link rel="stylesheet" type="text/css" href="{{asset('css/plugins/extensions/toastr.css')}}">
@endsection

@section('content-header')
    <div class="content-header-left col-9 mb-2 mt-1">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h5 class="content-header-title float-left pr-1 mb-0">Técnicos / Exibir #{{$operator->id}}</h5>
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb p-0 mb-0">
                        <li class="breadcrumb-item"><i class="bx bx-home-alt"></i> Home</li>
                        <li class="breadcrumb-item">Técnicos</li>
                        <li class="breadcrumb-item active">Exibir</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 d-flex justify-content-end align-items-center">
        @shield('expense.create')
        <a href="{{route('expense.create.operator', [$operator->uuid, 'startDate'=>$dataIni, 'endDate'=>$dataFim])}}" class="btn btn-primary">Lançar despesas</a>
        @endshield

        @shield('operator.tracking')
        <a href="{{route('operator.tracking', [$operator->uuid, 'startDate'=>$dataIni, 'endDate'=>$dataFim])}}" class="btn btn-primary">Tracking</a>
        @endshield


        @shield('operator.edit')
        <a class="btn btn-warning btn-group" role="group" href="{{ route('operators.edit', $operator->uuid) }}"><i class="bx bx-edit"></i> Editar</a>
        @endshield
        @shield('operator.destroy')
        <form action="{{ route('operators.destroy', $operator->uuid) }}" method="POST" style="display: inline;" onsubmit="if(confirm('Deseja realmente excluir esse item?')) { return true } else {return false };">
            <input type="hidden" name="_method" value="DELETE">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="btn-group pull-right" role="group" aria-label="...">
                <button type="submit" class="btn btn-danger">Excluir <i class="bx bx-trash"></i></button>
            </div>
        </form>
        @endshield
    </div>
@endsection

@section('content')
    @include('messages')
    @include('error')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="box-title">Monitoramento</h3>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <form class="form form-vertical" method="GET">
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label for="name">Período</label>
                                            <input type="text" class="form-control daterange" id="scheduled_date" name="scheduled_date" value="{{ app('request')->input('scheduled_date') }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <br>
                                            <button type="submit" class="btn btn-primary " id="btn-external-filter">Aplicar</button>
                                            <a href="{{route('operators.show',$operator->uuid)}}" class="btn btn-default">Limpar</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
                        <div class="badge-circle badge-circle-lg badge-circle-light-info mx-auto my-1">
                            <i class="bx bx-file font-medium-5"></i>
                        </div>
                        <p class="text-muted mb-0 line-ellipsis">Total de OS</p>
                        <h2 class="mb-0 box_total_os">{{$schedules_all}}</h2>
                        <div class="progress progress-bar-info mb-1 mt-1">
                            <div class="progress-bar  progress-bar-animated box_total_progress"
                                 role="progressbar" style="width: {{($schedules_all>0)? number_format((float)(($schedules_realized + $schedules_unsolved) / $schedules_all)*100, 2, '.', '') : "0"}}%"></div>
                        </div>
                        <span class="progress-description box_total_percent">{{($schedules_all>0)? number_format((float)(($schedules_realized + $schedules_unsolved) / $schedules_all)*100, 2, '.', '') : "0"}}% fechadas </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-2 padding-5 padding-tb-5">
            <div class="card text-center">
                <div class="card-content">
                    <div class="card-body">
                        <div class="badge-circle badge-circle-lg badge-circle-light-success mx-auto my-1">
                            <i class="bx bx-file font-medium-5"></i>
                        </div>
                        <p class="text-muted mb-0 line-ellipsis">Realizadas</p>
                        <h2 class="mb-0 box_total_os">{{$schedules_realized}}</h2>
                        <div class="progress progress-bar-success mb-1 mt-1">
                            <div class="progress-bar  progress-bar-animated box_total_progress"
                                 role="progressbar" style="width: {{($schedules_all>0)? number_format((float)($schedules_realized / $schedules_all)*100, 2, '.', '') : "0"}}%"></div>
                        </div>
                        <span class="progress-description box_total_percent">{{($schedules_all>0)? number_format((float)($schedules_realized / $schedules_all)*100, 2, '.', '') : "0"}}% do total </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-2 padding-5 padding-tb-5">
            <div class="card text-center">
                <div class="card-content">
                    <div class="card-body">
                        <div class="badge-circle badge-circle-lg badge-circle-light-danger mx-auto my-1">
                            <i class="bx bx-file font-medium-5"></i>
                        </div>
                        <p class="text-muted mb-0 line-ellipsis">Não realizadas</p>
                        <h2 class="mb-0 box_total_os">{{$schedules_unsolved}}</h2>
                        <div class="progress progress-bar-danger mb-1 mt-1">
                            <div class="progress-bar  progress-bar-animated box_total_progress"
                                 role="progressbar" style="width: {{($schedules_all>0)? number_format((float)($schedules_unsolved / $schedules_all)*100, 2, '.', '') : "0"}}%"></div>
                        </div>
                        <span class="progress-description box_total_percent">{{($schedules_all>0)? number_format((float)($schedules_unsolved / $schedules_all)*100, 2, '.', '') : "0"}}% do total </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-2 padding-5 padding-tb-5">
            <div class="card text-center">
                <div class="card-content">
                    <div class="card-body">
                        <div class="badge-circle badge-circle-lg badge-circle-light-warning mx-auto my-1">
                            <i class="bx bx-file font-medium-5"></i>
                        </div>
                        <p class="text-muted mb-0 line-ellipsis">Pendentes</p>
                        <h2 class="mb-0 box_total_os">{{$schedules_pending}}</h2>
                        <div class="progress progress-bar-warning mb-1 mt-1">
                            <div class="progress-bar  progress-bar-animated box_total_progress"
                                 role="progressbar" style="width: {{($schedules_all>0)? number_format((float)($schedules_pending / $schedules_all)*100, 2, '.', '') : "0"}}%"></div>
                        </div>
                        <span class="progress-description box_total_percent">{{($schedules_all>0)? number_format((float)($schedules_pending / $schedules_all)*100, 2, '.', '') : "0"}}% do total </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-2 padding-5 padding-tb-5">
            <div class="card text-center">
                <div class="card-content">
                    <div class="card-body">
                        <div class="badge-circle badge-circle-lg badge-circle-light-primary mx-auto my-1">
                            <i class="bx bx-file font-medium-5"></i>
                        </div>
                        <p class="text-muted mb-0 line-ellipsis">Tempo Médio</p>
                        <h2 class="mb-0 box_total_os">{{$tempoAtendimentoPorOs}} min</h2>
                        <div class="progress progress-bar-primary mb-1 mt-1">
                            <div class="progress-bar  progress-bar-animated box_total_progress"
                                 role="progressbar" style="width: {{($schedules_all>0)? number_format((float)($schedules_pending / $schedules_all)*100, 2, '.', '') : "0"}}%"></div>
                        </div>
                        <span class="progress-description box_total_percent">Execução </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <h4>Última localização</h4>
                                <br>
                                <div id="map"></div>
                            </div>
                            <div class="col-6">
                                <h4>Deslocamentos do dia</h4> (30 últimos pontos do GPS)
                                @if(count($tracking))
                                    <div id="mapRoteiro"></div>
                                @else
                                    <div><p>Roteiro ainda não iniciado ou não houve deslocamento do técnico</p></div>
                                @endif
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
                    <h4 class="box-title">Dados do Técnico</h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-3">
                                <div class="form-group">
                                    <label for="foto">Foto do técnico</label>
                                    <p class="form-control-static">
                                        <img src="{{ $operator->foto ? : "/img/techinical.png" }}" alt="" class="img-responsive" style="width: 100%; padding-right: 10px;">
                                    </p>
                                </div>
                            </div>
                            <div class="col-9">
                                <div class="row">
                                    <div class="col-2 form-group">
                                        <label for="foto">ID</label>
                                        <p class="form-control-static">{{$operator->id}}</p>
                                    </div>
                                    <div class="col-7 form-group">
                                        <label for="foto">Nome</label>
                                        <p class="form-control-static">{{$operator->name}}</p>
                                    </div>
                                    <div class="col-3 form-group">
                                        <label for="foto">Status</label>
                                        <p class="form-control-static">{{($operator->status == 1)? "Habilitado" : "Desabilitado"}}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6 form-group">
                                        <label for="foto">CPF</label>
                                        <p class="form-control-static">{{$operator->cpf}}</p>
                                    </div>
                                    <div class="col-6 form-group">
                                        <label for="foto">Email</label>
                                        <p class="form-control-static">{{$operator->email}}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 form-group">
                                        <label for="foto">Empresa</label>
                                        <p class="form-control-static">{{optional($operator->contractor)->name}}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-4 form-group">
                                        <label for="foto">CNH</label>
                                        <p class="form-control-static">{{$operator->cnh}}</p>
                                    </div>
                                    <div class="col-4 form-group">
                                        <label for="foto">Tipo CNH</label>
                                        <p class="form-control-static">{{$operator->cnh_type}}</p>
                                    </div>
                                    <div class="col-4 form-group">
                                        <label for="foto">Validade CNH</label>
                                        <p class="form-control-static">{{$operator->cnh_expires()}}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6 form-group">
                                        <label for="foto">Equipamento (Celular)</label>
                                        <p class="form-control-static">{{$operator->device}} Version: {{$operator->device_version}}</p>
                                    </div>
                                    <div class="col-4 form-group">
                                        <label for="foto">Código do Celular</label>
                                        <p class="form-control-static">{{$operator->mobile_number}}</p>
                                    </div>
                                    <div class="col-2 form-group">
                                        <label for="foto">Bateria do Celular</label>
                                        <p class="form-control-static">{{$operator->battery}}</p>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-6 form-group">
                                        <label for="foto">Ponto de Partida</label>
                                        <p class="form-control-static">{{$operator->operator_start_point?:optional($operator->contractor)->address}}</p>
                                    </div>
                                    <div class="col-6 form-group">
                                        <label for="foto">Ponto de chegada</label>
                                        <p class="form-control-static">{{$operator->operator_arrival_point?:optional($operator->contractor)->address}}</p>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include("operators.includes.moves")
    @include("operators.includes.occurrences")
    @include("operators.includes.workday")
    @include("operators.includes.team")
    @include("operators.includes.zones")
    @include("operators.includes.skills")
    @include("operators.includes.equipments")
    @include("operators.includes.linked_vehicle")
    @include("operators.includes.checklist_vehicles")
    @include("operators.includes.conectividade")

    <a class="btn btn-primary" href="{{ route('operators.index') }}"><i class="bx bx-arrow-back"></i> Voltar</a>

@endsection


@section('scripts')
    <script src="{{asset('vendors/js/extensions/toastr.min.js')}}"></script>
    <script src="{{asset('vendors/js/pickers/daterange/moment.min.js')}}"></script>
    <script src="{{asset('vendors/js/pickers/daterange/daterangepicker.js')}}"></script>
    <!-- Jquery UI -->
    <script src="{{ url('/bower_components/jquery-ui/jquery-ui.min.js') }}"></script>
    <style nonce="{{ csp_nonce() }}">
        #mapRoteiro {
            height: 0;
            overflow: hidden;
            padding-bottom: 22.25%;
            padding-top: 222px;
            position: relative;
        }
    </style>


    <!-- Make sure you put this AFTER Leaflet's CSS -->
    <script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js"
            integrity="sha512-gZwIG9x3wUXg2hdXF6+rVkLF/0Vi9U8D2Ntg4Ga5I5BZpVkVxlJWbSQtXPSiUTtC0TjtGOmxa1AJPuV0CPthew=="
            crossorigin=""></script>
    <script src="https://unpkg.com/leaflet.icon.glyph@0.2.0/Leaflet.Icon.Glyph.js"></script>
    <script src="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.js"></script>
    <!-- Leaflet Routing Machine -->
    <script src="/leaflet-routing-machine/dist/leaflet-routing-machine.min.js"></script>
    <script nonce="{{ csp_nonce() }}">

        $(document).on("click", ".open-modal-img", function () {
            let image = $(this).data("image");
            $("#recebe-image").attr("src", image);
        });

        @if(count($tracking))
        //monitoramento leafletJS

        var mapLet = L.map('mapRoteiro', {
            center: [{{$tracking[0]->latitude}}, {{$tracking[0]->longitude}}],
            zoom: 9.8,
            zoomControl: true,
            scrollWheelZoom: false,
        });

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.centralsystem.com.br">CentralSystem</a> contributors'
        }).addTo(mapLet);

        showRouteByTracking();

        // // Cria rota percorrida pelo motorista com base no tracking
        function showRouteByTracking() {

            // define os waypoints
            waypts = [];
            @if(count($tracking) > 0)
            @foreach($tracking as $coord)
            waypts.push({
                lat: "{{$coord->latitude}}",
                lng: "{{$coord->longitude}}"
            });
            @endforeach
                @endif

            if (waypts.length === 0) {
                return;
            }

            // waypoints
            let aWaypoints = [];
            for (let i = 0; i < waypts.length; i++) {
                aWaypoints.push(L.latLng(waypts[i].lat, waypts[i].lng));
            }

            console.log(aWaypoints);

            // Renderiza a rota no mapa
            L.Routing.control({
                waypoints: aWaypoints,
                language: 'pt-BR',
                showAlternatives: false,
                lineOptions: {
                    styles: [{
                        color: '#121416', opacity: 0.8, weight: 4
                    }],
                    addWaypoints: false, // desabilita criacao de novo waypoint
                    linetouched: function () {
                        return false; // desabilita evento de clique nas linhas da rota
                    }
                },
                createMarker: function (i, start, n) {

                    let popupText = "";
                    if (i === 0) {
                        // This is the first marker, indicating start
                        popupText = "Início";
                    } else if (i === (n - 1)) {
                        //This is the last marker indicating destination
                        popupText = "Fim";
                    } else {
                        return null;
                    }

                    return L.marker(start.latLng, {
                        title: popupText,
                        draggable: false,
                        bounceOnAdd: false,
                    }).bindTooltip(popupText, {permanent: true, offset: [2, 10]});
                }
            }).addTo(mapLet) // adiciona ao mapa
                .hide(); // minimiza as instrucoes do itinerario
        }

        @if(!empty($operator->longitude) && !empty($operator->latitude))
        var mapLet = L.map('map', {
            center: [{{$operator->latitude}},{{$operator->longitude}}],
            zoom: 14,
            zoomControl: true,
            scrollWheelZoom: false,
        });
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.centralsystem.com.br">CentralSystem</a> contributors'
        }).addTo(mapLet);

        var greenIcon = L.icon({
            iconUrl: '{{$operator->contractor->icon}}',
        });

        L.marker([{{$operator->latitude}},{{$operator->longitude}}], {icon: greenIcon}).addTo(mapLet);
        @endif

        @endif



        $(function () {
            $('.daterange').daterangepicker({
                autoApply: false,
                autoUpdateInput: false,
//                maxDate: moment(),
                locale: {
                    format: 'DD/MM/YYYY',
                    cancelLabel: 'Limpar',
                    applyLabel: "Ok",
                    fromLabel: "De",
                    toLabel: "Até",
                    daysOfWeek: [
                        "D",
                        "S",
                        "T",
                        "Q",
                        "Q",
                        "S",
                        "S"
                    ],
                    monthNames: [
                        "Janeiro",
                        "Fevereiro",
                        "Março",
                        "Abril",
                        "Maio",
                        "Junho",
                        "Julho",
                        "Agosto",
                        "Setembro",
                        "Outubro",
                        "Novembro",
                        "Dezembro"
                    ],
                },
            });

            $('.daterange').on('apply.daterangepicker', function (ev, picker) {
                $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
            });
            $('.daterange').on('cancel.daterangepicker', function (ev, picker) {
                $(this).val('');
            });
        });


        $(function () {
            $(".sortable").sortable({
                // item: '> tr> td:first',
                handle: '.grabbable',
                update: function () {
                    var ordem_atual = $(this).sortable("toArray", "data");
                    var operator = {{$operator->id}}

                    $.ajax({
                        headers: {
                            'X-CSRF-Token': $('input[name="_token"]').val()
                        },
                        type: 'PUT',
                        url: '{{route("occurrence.order.order")}}',
                        data: {ordem_atual: ordem_atual, operator: operator},
                        success: function (data) {
                            setTimeout(function () {
                                toastr.success("Ocorrências ordenadas com sucesso");
                            }, 3000);
                        },
                        error: function () {
                            toastr.warning("Ocorreu um erro inesperado durante o processamento.\nRecarregue a página e tente novamente");
                        },
                    });

                }
            });
        });

        $(function () {
            $('#route').click(function (e) {
                e.preventDefault();
                $.ajax({
                    type: 'GET',
                    url: '{{route("occurrence.order.route", $operator->id)}}',
                    success: function (data) {
                        setTimeout(function () {
                            location.reload();
                        }, 1000);
                        toastr.success("Ocorrências ordenadas com sucesso");


                    },
                    error: function () {
                        toastr.warning("Ocorreu um erro inesperado durante o processamento.\nRecarregue a página e tente novamente");
                    },
                })
            })
        })

    </script>
@endsection
