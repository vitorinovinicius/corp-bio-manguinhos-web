@extends('layouts.adminlte')
@section('title','- Serviços / Exibir #'.$occurrence->id)
@section('css')
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ url('/bower_components/AdminLTE/plugins/select2/select2.min.css') }}">
    <!-- Pace style -->
    <link rel="stylesheet" href="{{env('APP_URL')}}{{ url('/bower_components/AdminLTE/plugins/pace/pace.min.css') }}">
@endsection
@section('header')
    <meta name="_token" content="{!! csrf_token() !!}"/>
    <div class="page-header">
        <h3>Serviços / Exibir #{{$occurrence->id}}</h3>

        @if($occurrence->status == 1)
            @shield('occurrence.edit')
            <a class="btn btn-warning btn-group pull-right" role="group" href="{{ route('occurrences.edit', $occurrence->uuid) }}"><i class="bx bx-edit"></i> Editar</a>
            @endshield
        @endif
        @if($occurrence->status != 1)
            <a class="btn btn-primary pull-right  btn-group reenviaLaudo" href="#"><i class="bx bx-mail-forward"></i> Envia email</a>
        @endif
        <a class="btn btn-primary  pull-right" href="{{route('admin.occurrences.pdfGenerate',[$occurrence->uuid])}}" target="_blank"><i class="bx bx-file-pdf-o"></i> Gerar PDF</a>
        <button class="btn btn-primary  pull-right" data-toggle="modal" data-target="#modal-anexo"><i class="bx bx-upload"></i> Enexar arquivos</button>
{{--        <a class="btn btn-primary  pull-right" href="" data-target="#modal-default"><i class="bx bx-upload"></i> Enexar arquivos</a>--}}
        @if($occurrence->occurrence_images->count())
            <a class="btn btn-success  pull-right downloadImages" href="javascript:void(0);"><i class="bx bx-download-alt"></i> Baixar fotos</a>
        @endif
        @is('superuser')
        @if(!empty($occurrence->url))
            <a class="btn btn-success  pull-right" href="{{$occurrence->url}}" target="_blank"><i class="bx bx-share"></i> JSON OS</a>
        @endif
        @endis
        @if(!empty($occurrence->operator_id) && $occurrence->moves()->where('move_type_id',4)->first() && $occurrence->status == 1 && $occurrence->smses)
            <a href="{{route('occurrences.tracert',$occurrence->uuid)}}" target="_blank" class="btn btn-info  pull-right"><i class="bx bx-user"></i> Acompanhamento</a>
        @endif
        @if($occurrence->status == 2)
            @if($occurrence->financial)
                <a href="{{route('financials.show',$occurrence->financial->uuid)}}" target="_blank" class="btn btn-warning pull-right"><i class="bx bx-money"></i> Interação administrativa</a>
            @else
                @is(['superuser','financeiro'])
                <a href="{{route('financials.create',$occurrence->uuid)}}" target="_blank" class="btn btn-primary pull-right"><i class="bx bx-money"></i> Aprovar OS</a>
                @endis
            @endif
        @endif
        <a class="btn btn-primary  pull-right" href="{{URL::previous()}}"><i class="bx bx-arrow-back"></i> Voltar</a>
    </div>
    <ol class="breadcrumb">
        <li><a href="/admin"><i class="bx bx-dashboard"></i> Home</a></li>
        <li> Serviços</li>
        <li class="active">Exibir</li>
    </ol>


@endsection

@section('content')

    @include('messages')
    @include('error')

    <!-- Detalhes do Serviço e cliente -->
    @include("occurrences.includes.occurrence")

    {{--DADOS BASICOS--}}
    @include("occurrences.includes.dados_basicos")

    {{--MOVES--}}
    @include("occurrences.includes.localizacao")

    {{--EXECUÇÃO DOS FORMULÁRIOS--}}
    @include("occurrences.includes.formularios")

    {{--EXECUÇÃO DOS SERVIÇOS--}}
    @include("occurrences.includes.executions.execution")


    {{--DADOS DE EXECUÇÃO--}}
    @include("occurrences.includes.dados_atendimento")

    {{--IMAGENS GERAIS--}}
    @include('occurrences.includes.occurrenceImage')


    <div class="row">
        <div class="col-md-12">
            <a class="btn btn-primary  pull-right hidden-print" href="{{URL::previous()}}"><i class="bx bx-arrow-back"></i> Voltar</a>
        </div>
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
                    <div><img class="img-responsive max-75vh" id="recebe-image"></div>
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
            <div class="modal-content col-md-8 col-md-offset-2">
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
                                <div class="form-group col-md-8">
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
@endsection
@section('scripts')

    <!-- Select2 -->
    <script src="{{ url('/bower_components/AdminLTE/plugins/select2/select2.full.min.js') }}"></script>
    <script src="{{ url('/bower_components/AdminLTE/plugins/pace/pace.min.js') }}"></script>
    <script src="{{ url('/js/jQueryRotate.js') }}"></script>
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

                if ($(this).hasClass("label-primary")) {
                    $(this).removeClass("label-primary");
                    $(this).addClass("label-danger");
                    $(this).html("Não");
                    changeStatusSchedule(1, "Não");

                } else {
                    $(this).removeClass("label-danger");
                    $(this).addClass("label-primary");
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


    </script>
@endsection
