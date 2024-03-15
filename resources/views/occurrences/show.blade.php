@extends('layouts.frest_template')
@section('title','- Serviços / Exibir #'.$occurrence->id)
@section('css')
{{--    <link rel="stylesheet" href="{{ url('/css/admin.css') }}">--}}
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ url('/bower_components/AdminLTE/plugins/select2/select2.min.css') }}">
    <!-- Pace style -->
    <link rel="stylesheet" href="{{ url('/bower_components/AdminLTE/plugins/pace/pace.min.css') }}">
    @if(env('TIPO_MAPA') == 'LEAFLETJS')
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css"
              integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ=="
              crossorigin=""/>
        <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.css" />
        {{--        <link href="https://api.mapbox.com/mapbox-gl-js/v1.10.0/mapbox-gl.css" rel="stylesheet" />--}}
        <link
                rel="stylesheet"
                href="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-directions/v4.0.2/mapbox-gl-directions.css"
                type="text/css"
        />
        <link
                rel="stylesheet"
                href="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v4.5.1/mapbox-gl-geocoder.css"
                type="text/css"
        />
        <!-- DataTables -->
        <link rel="stylesheet" type="text/css" href="{{ url('vendors/css/tables/datatable/datatables.min.css') }}">

        <style nonce="{{ csp_nonce() }}">
            #map { position: absolute; top: 0; bottom: 0; width: 100%; }
        </style>
    @endif
@endsection

@section('content-header')

    <meta name="_token" content="{!! csrf_token() !!}"/>
    <div class="content-header-left col-8 mb-2 mt-1">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h5 class="content-header-title float-left pr-1 mb-0">Serviços / Exibir #{{$occurrence->id}}</h5>
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb p-0 mb-0">
                        <li class="breadcrumb-item"><i class="bx bx-home-alt"></i> Home</li>
                        <li class="breadcrumb-item">Serviços</li>
                        <li class="breadcrumb-item active">Exibir</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 d-flex justify-content-end align-items-center">
        <div class="btn-group">
            <a class="btn btn-primary  pull-right" href="{{URL::previous()}}"><i class="bx bx-arrow-back"></i> Voltar</a>
            @if($occurrence->status == 2 )
                @if($occurrence->financial)
                    <a href="{{route('financials.show',$occurrence->financial->uuid)}}" target="_blank" class="btn btn-warning pull-right"><i class="bx bx-check"></i> Interação administrativa</a>
                @else
                    @is(['superuser','financeiro','regiao'])
                    <a href="{{route('financials.create',$occurrence->uuid)}}" target="_blank" class="btn btn-primary pull-right"><i class="bx bx-check"></i> Aprovar OS</a>
                    @endis
                @endif
            @endif
            @if(!empty($occurrence->operator_id) && $occurrence->moves()->where('move_type_id',4)->first() && $occurrence->status == 1 && $occurrence->smses)
                <a href="{{route('occurrences.tracert',$occurrence->uuid)}}" target="_blank" class="btn btn-info  pull-right"><i class="bx bx-user"></i> Acompanhamento</a>
            @endif
            @is(['superuser', 'admin'])
            {{-- @if(!empty($occurrence->url))
                <a class="btn btn-success  pull-right" href="{{$occurrence->url}}" target="_blank"><i class="bx bx-share"></i> JSON OS</a>
            @endif

            <button class="btn btn-primary  pull-right" data-toggle="modal" data-target="#modal-json">
                <i class="bx bx-upload"></i> Enviar Json
            </button> --}}
            <a class="btn btn-success  pull-right" href="{{ route('occurrence.upload.json', $occurrence->uuid)}}"><i class="bx bx-share"></i> Enviar Json</a>
            @endis
            <div class="btn-group" role="group">
                <button class="btn btn-primary dropdown-toggle pull-right"  id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="bx bx-download"></i> Baixar
                </button>
                @if($occurrence->occurrence_archives->count() || $occurrence->occurrence_images->count())
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="">

                        @if($occurrence->occurrence_archives->count())
                            <a class="btn btn-link dropdown-item downloadFiles" href="javascript:void(0);">Baixar anexos</a>
                        @endif

                        @if($occurrence->occurrence_images->count())
                            <a class="btn btn-link dropdown-item downloadImages" href="javascript:void(0);">Baixar fotos</a>
                        @endif
                    </div>
                @endif
            </div>

            <div class="btn-group" role="group">
                <button class="btn btn-primary dropdown-toggle pull-right"  id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="bx bx-paperclip"></i> Anexar
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="">
                    <button class="btn btn-link dropdown-item" data-toggle="modal" data-target="#modal-anexo"> Arquivos</button>
                    <button class="btn btn-link dropdown-item" data-toggle="modal" data-target="#modal-anexo-fotos"> Fotos/Imagens</button>
                </div>
            </div>

            <div class="btn-group" role="group">
                <button class="btn btn-primary dropdown-toggle pull-right"  id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="bx bxs-file-pdf"></i> PDF
                </button>

                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="">
                    <a class="btn dropdown-item" href="{{route('admin.occurrences.pdfGenerate',[$occurrence->uuid])}}" target="_blank">Com fotos</a>
                    <a class="btn dropdown-item" href="{{route('admin.occurrences.pdfGenerate',[$occurrence->uuid, 1])}}" target="_blank">Sem fotos</a>
                </div>
            </div>
            @if($occurrence->status != 1)
                <a class="btn btn-primary pull-right reenviaLaudo" href="#"><i class="bx bx-mail-send"></i> Envia email</a>
            @endif
            @if($occurrence->status == 1)
                @shield('occurrence.edit')
                <a class="btn btn-warning pull-right" role="group" href="{{ route('occurrences.edit', $occurrence->uuid) }}"><i class="bx bx-pencil"></i> Editar</a>
                @endshield
                @shield('occurrence.edit')
                <a class="btn btn-warning pull-right" role="group" href="{{ route('occurrences.execute', $occurrence->uuid) }}"><i class="bx bx-pencil"></i> Executar OS </a>
                @endshield
            @endif
            @if($occurrence->model_evaluation)
                <a class="btn btn-primary  pull-right" href="{{ route('evaluation.show', $occurrence->model_evaluation->uuid) }}" target="_black"><i class="bx bx-note"></i> Avaliação atendimento</a>
            @endif

        </div>
    </div>
@endsection

@section('content')

    @include('messages')
    @include('error')

    <!-- Detalhes do Serviço e cliente -->
    @include("occurrences.includes.occurrence")

    @include("occurrences.includes.dados_cliente")

    @include("occurrences.includes.occurrences_cliente")

    @include("occurrences.includes.occurrence_archives")

    {{--DADOS BASICOS--}}
{{--    @include("occurrences.includes.dados_basicos")--}}

    {{--MOVES--}}
    @include("occurrences.includes.localizacao")

    {{--ALERTS--}}
    @include("occurrences.includes.alerts.index")

    {{--DADOS DO ATENDIMENTO AO CLIENTE--}}
    @include("occurrences.includes.occurrence_data_client")

    {{--EXECUÇÃO DOS FORMULÁRIOS--}}
    @include("occurrences.includes.formularios")

    {{--INTERFERENCIAS--}}
    @include("occurrences.includes.dados_interferencia")

    {{--DADOS DE Atendimento--}}
    @include("occurrences.includes.dados_atendimento")

    {{--IMAGENS GERAIS--}}
    @include('occurrences.includes.occurrenceImage')

    @include('occurrences.includes.occurrence_image_extra')

    {{--DADOS DA AVALIAÇÃO--}}
    @include("occurrences.includes.evaluation")


    <div class="row">
        <div class="col-md-12 padding-20">
            <a class="btn btn-primary  pull-right hidden-print" href="{{URL::previous()}}"><i class="bx bx-arrow-back"></i> Voltar</a>
        </div>
    </div>

    {{--    Modal para envio do json--}}
    <div class="modal fade" id="modal-json" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary white">
                    <h5 class="modal-title white">Adicionar Json</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('occurrence.upload.json', $occurrence->uuid)}}" method="POST" enctype="multipart/form-data">
                        <div class="box-body">
                            <div>
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <div class="form-group">
                                    <label for="upload_json">Json</label>
                                    <div><input type="file" class="form-control" name="json" id="upload_json" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                            <button type="submit" class="btn btn-primary pull-left">Enviar</button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <div class="modal fade" id="imgModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" title="Fechar">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Imagem ampliada</h4>
                </div>
                <div class="modal-body">
                    <div><img class="img-responsive max-75vh"
                              style="display: block; max-width: 100%; height:auto;" id="recebe-image"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>

    {{--    Modal para inclusão de arquivos--}}
    <div class="modal fade" id="modal-anexo" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span></button>
                    <h4 class="modal-title">Anexar arquivos</h4>
                </div>
                <div class="modal-body">
                    <form action="{{ route('occurrence_archives.store') }}" method="POST" enctype="multipart/form-data">
                            <div class="box-body">
                            <div>
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" name="occurrence" value="{{$occurrence->id}}">
                                <input type="hidden" name="occurrence_uuid" value="{{$occurrence->uuid}}">
                                <div class="form-group">
                                    <label for="anexo">Anexo</label>
                                    <p class="text-yellow"><small>Precine Ctrl para anexar mais de um arquivo</small></p>
                                    <div><input type="file" class="form-control" name="anexos[]" id="anexo" multiple></div>
                                </div>
                            </div>
                        </div>
                        {{-- <div class="box-footer">
                        </div> --}}
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary pull-left">Enviar</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    {{--    Modal para inclusão de fotos--}}
    <div class="modal fade" id="modal-anexo-fotos" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span></button>
                    <h4 class="modal-title">Anexar fotos</h4>
                </div>
                <div class="modal-body">
                    <form action="{{ route('occurrence_photos_uploads.store') }}" method="POST" enctype="multipart/form-data">
                            <div class="box-body">
                            <div>
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" name="occurrence" value="{{$occurrence->id}}">
                                <input type="hidden" name="occurrence_uuid" value="{{$occurrence->uuid}}">
                                <div class="form-group">
                                    <label for="anexo">Fotos</label>
                                    <p class="text-yellow"><small>Precine Ctrl para anexar mais de um arquivo</small></p>
                                    <div><input type="file" class="form-control" name="foto_extra[]" id="foto_extra" multiple></div>
                                </div>
                            </div>
                        </div>
                        {{-- <div class="box-footer">
                        </div> --}}
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary pull-left">Enviar</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
@endsection
@section('scripts2')

    <script nonce="{{ csp_nonce() }}">

        function playAudio(id) {
            play = document.getElementById(id).play();
        }
        function pauseAudio(id) {
            document.getElementById(id).pause();
        }
    </script>
    <!-- Select2 -->
    <script src="{{ url('/bower_components/AdminLTE/plugins/select2/select2.full.min.js') }}"></script>
    <script src="{{ url('/bower_components/AdminLTE/plugins/pace/pace.min.js') }}"></script>
    <script src="{{ url('/js/jQueryRotate.js') }}"></script>
    <!-- DataTables -->
{{--    <script src="/js/datatables/jquery.dataTables.min.js"></script>--}}
{{--    <script src="/js/datatables/dataTables.bootstrap.min.js"></script>--}}
        <script src="{{ url('vendors/js/tables/datatable/datatables.min.js') }}"></script>
        <script src="{{ url('vendors/js/tables/datatable/dataTables.bootstrap4.min.js') }}"></script>

    <script nonce="{{ csp_nonce() }}">

        function changeStatusSchedule(status, name) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            }),
                jQuery.ajax({
                    type: 'POST',
                    url: '{{route("occurrence.change.status_schedule",["occurrence_id"=>$occurrence->id])}}' + '&status=' + status,
                    beforeSend: function () {
                        jQuery("#btnReagendar").attr('disabled', true);
                        jQuery("#btnReagendar").html('<i class="bx bx-refresh fa-spin"></i> Aguarde...');
                    },
                    success: function (data) {
                        jQuery("#btnReagendar").attr('disabled', false);
                        jQuery("#btnReagendar").html(name);
                    },
                });
        }

        $(function () {

            $("#btnReagendar").on("click", function () {

                if ($(this).hasClass("btn-primary")) {
                    $(this).removeClass("btn-primary");
                    $(this).addClass("btn-danger");
                    $(this).html("Não");
                    changeStatusSchedule(1, "Não");

                } else {
                    $(this).removeClass("btn-danger");
                    $(this).addClass("btn-primary");
                    $(this).html("Sim");
                    changeStatusSchedule(2, "Sim");
                }

            });
            //Initialize Select2 Elements
            $(".select2").select2({
                allowClear: true,
                width: '80%',
            });
            $(document).on('click', '.downloadImages', function (e) {
                e.preventDefault();
                if ($('.downloadImages').attr("disabled")) {
                    return false;
                }
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                }),
                    jQuery.ajax({
                        type: 'POST',
                        url: '{{route("occurrence.images.download",["occurrence_id"=>$occurrence->id])}}',
                        beforeSend: function () {
                            jQuery(".downloadImages").attr('disabled', true);
                            jQuery(".downloadImages").html('<i class="bx bx-refresh fa-spin"></i> Aguarde...');
                        },
                        success: function (data) {
                            jQuery(".downloadImages").attr('disabled', false);
                            jQuery(".downloadImages").html('<i class="bx bx-download-alt"></i> Baixar fotos');
                            if (data.retorno == 2) {
                                alert(data.mensagem);
                            } else {
                                location.href = "/export_images.zip";
                            }
                        },
                        error: function () {
                            jQuery(".downloadImages").attr('disabled', false);
                            jQuery(".downloadImages").html('<i class="bx bx-download-alt"></i> Baixar fotos');
                            alert("Ocorreu um erro inesperado durante o processamento!\n Recarrege a página e tente novamente.");
                        }
                    });
            });

            $(document).on('click', '.downloadFiles', function (e) {
                e.preventDefault();
                if ($('.downloadFiles').attr("disabled")) {
                    return false;
                }
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                }),
                    jQuery.ajax({
                        type: 'POST',
                        url: '{{route("occurrence.anexos.download",["occurrence_id"=>$occurrence->id])}}',
                        beforeSend: function () {
                            jQuery(".downloadFiles").attr('disabled', true);
                            jQuery(".downloadFiles").html('<i class="bx bx-refresh fa-spin"></i> Aguarde...');
                        },
                        success: function (data) {
                            jQuery(".downloadFiles").attr('disabled', false);
                            jQuery(".downloadFiles").html('<i class="bx bx-download-alt"></i> Baixar fotos');
                            if (data.retorno == 2) {
                                alert(data.mensagem);
                            } else {
                                location.href = "/export_anexos.zip";
                            }
                        },
                        error: function () {
                            jQuery(".downloadFiles").attr('disabled', false);
                            jQuery(".downloadFiles").html('<i class="bx bx-download-alt"></i> Baixar anexos');
                            alert("Ocorreu um erro inesperado durante o processamento!\n Recarrege a página e tente novamente.");
                        }
                    });
            });
        });

        $(document).on("click", ".open-modal-img", function () {
            let image = $(this).data("image");
            $("#recebe-image").attr("src", image);
        });

        var value = 0;
        $(".rotate-image").rotate({

            bind: {
                click: function () {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                        }
                    });

                    let image = $(this).data("image");
                    let rotate = $(this).data("rotate");
                    let imageId = $(this).data("id");
                    let this2 = $(this);

                    $.ajax({
                        type: 'POST',
                        url: '{{ url("/admin/helper/rotate") }}',
                        data: "image=" + image + "&rotate=" + rotate,
                        beforeSend: function () {
//                            $("<span class='load-imagem'></span>").appendTo(this2);
                            $(this2.parent().parent()).prepend("<div class='load-div'></div>");
                        },
                        success: function (data) {
                            if (data.retorno = 1) {
                                //rotaciona a imagem
                                if ($("#image-rotate-" + imageId).getRotateAngle() == "")
                                    value = 0;
                                else {
                                    value = parseInt($("#image-rotate-" + imageId).getRotateAngle());
                                }

                                value += 90;
                                $("#image-rotate-" + imageId).rotate({animateTo: value});
                            } else {
                                alert("Ocorreu algum erro, tente novamente a operação");
                            }
                            $(".load-div").remove();
                        },
                        error: function () {
                            $(".load-div").remove();
                            alert("Ocorreu um erro inesperado durante o processamento.\nRecarregue a página e tente novamente");
                        }
                    });
                }
            }
        });

        $(document).on('click', '.reenviaLaudo', function (e) {
            e.preventDefault();
            if ($('.reenviaLaudo').attr("disabled")) {
                return false;
            }
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            }),
                jQuery.ajax({
                    type: 'POST',
                    url: '{{route("mails.envia_os_completa",$occurrence->uuid)}}',

                    beforeSend: function () {
                        jQuery(".reenviaLaudo").attr('disabled', true);
                        jQuery(".reenviaLaudo").html('<i class="bx bx-refresh fa-spin"></i> Aguarde...');
                    },
                    success: function (data) {
                        jQuery(".reenviaLaudo").attr('disabled', false);
                        jQuery(".reenviaLaudo").html('<i class="bx bx-mail-forward"></i> Envia e-mail');
                        if (data.retorno == 2) {
                            alert(data.mensagem);
                        } else {
                            alert("Laudo enviado com sucesso!");
                        }
                    },
                    error: function () {
                        jQuery(".reenviaLaudo").attr('disabled', false);
                        jQuery(".reenviaLaudo").html('<i class="bx bx-mail-forward"></i> Envia e-mail');
                        alert("Ocorreu um erro inesperado durante o processamento!\n Recarrege a página e tente novamente.");
                    }
                });
        });

        $(document).on("click", ".removeImage", function (e) {
            e.preventDefault();
            var status = confirm("Deseja realmente remover essa Imagem?");
            if (status == false) {
                return false;
            }
            var id = $(this).data("id");
            var url = $(this).data("url");
            var this2 = $(this);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            }),
                jQuery.ajax({
                    type: 'POST',
                    url: '{{route("occurrence.remove_file")}}',
                    data: "id=" + id + "&url=" + url,

                    success: function (data) {
                        if (data.retorno == 2) {
                            alert(data.mensagem);
                        } else {
                            alert(data.mensagem);
                            $(this2).parent().remove();
                        }
                    },
                    error: function () {
                        alert("Ocorreu um erro inesperado durante o processamento!\n Recarrege a página e tente novamente.");
                    }
                });
            return false;
        });

        $('.data-table').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": true,
            "language": {
                "url": "{{url('vendors/js/tables/datatable/lang/pt-br.json')}}"
            }
        });

    </script>
@endsection
