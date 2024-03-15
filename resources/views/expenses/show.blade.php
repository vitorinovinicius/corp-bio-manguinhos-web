@extends('layouts.frest_template')
@section('css')
    <link rel="stylesheet" href="/bower_components/AdminLTE/plugins/select2/select2.min.css">
@endsection

@section('content-header')
    <div class="content-header-left col-10 mb-2 mt-1">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h5 class="content-header-title float-left pr-1 mb-0">Despesas</h5>
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb p-0 mb-0">
                        <li class="breadcrumb-item"><i class="bx bx-home-alt"></i> Home</li>
                        <li class="breadcrumb-item active">Despesa</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="col-2 d-flex justify-content-end align-items-center">

        <form action="{{ route('expense.destroy', $expense->uuid) }}" method="POST" style="display: inline;" onsubmit="if(confirm('Deseja realmente excluir esse item?')) { return true } else {return false };">
            <input type="hidden" name="_method" value="DELETE">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="btn-group pull-right" role="group" aria-label="...">
                @shield('expense.edit')
                <a class="btn btn-warning btn-group" role="group" href="{{route('expense.edit', $expense->uuid)}}"><i class="bx bx-edit"></i> Editar</a>
                @endshield
                @shield('expense.destroy')
                <button type="submit" class="btn btn-danger">Excluir <i class="bx bx-trash"></i></button>
                @endshield
            </div>
        </form>

    </div>
@endsection

@section('content')
    @include('messages')
    @include('error')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="box-title">Dados da despesa</h3>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <div class="row">
                            @is('superuser')
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Empreiteira</label>
                                    <p class="form-control-static">{{optional($expense->contractor)->name}}</p>
                                </div>
                            </div>
                            @endis
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Técnico</label>
                                    <p class="form-control-static">{{optional($expense->user)->name}}</p>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>OS</label>
                                    <p class="form-control-static">{{$expense->occurrence_id}}</p>
                                </div>
                            </div>

                            <div class="col-4">
                                <div class="form-group">
                                    <label>Tipo de despesa</label>
                                    <p class="form-control-static">{{optional($expense->expenseTypes)->name}}</p>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Categoria</label>
                                    <p class="form-control-static">{{$expense->category()}}</p>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Valor</label>
                                    <p class="form-control-static">{{number_format((float)$expense->value, 2, ',', '.')}}</p>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Comentário</label>
                                    <p class="form-control-static">{{$expense->comment}}</p>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Status</label>
                                    <p class="form-control-static">{{$expense->statuses()}}</p>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Motivo do cancelamento</label>
                                    <p class="form-control-static">{{$expense->cancellation_reason}}</p>
                                </div>
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
                    <h3 class="box-title">Comprovante</h3>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <div class="row">
                            @if($expense->archives)
                                @foreach($expense->archives as $fotos)
                                    <div class="col-md-2 text-center ">
                                        <img src="{{$fotos->url}}" alt="" class="img-thumbnail cursor-pointer open-modal-img" id="image-rotate-{{$fotos->id}}" data-toggle="modal" data-target="#imgModal" data-image="{{$fotos->url}}">

                                        <div>
                                            <a href="javascript:void(0);" class="btn btn-link rotate-image" data-image="{{$fotos->url}}" data-rotate="270" data-id="{{$fotos->id}}">Girar imagem
                                                <i class="fa fa-rotate-right"></i></a>
                                        </div>


                                        @is(['superuser'])
                                        <a href="#" class="btn btn-danger removeImage" title="Remover arquivo" data-id="{{$fotos->id}}" data-url="{{ $fotos->url }}"><i class="bx bx-trash-alt"></i></a>
                                        @endis

                                    </div>
                                @endforeach
                            @else
                                <div class="col-12 text-center">
                                    <p class="form-control-static">Não há mais imagens</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if(strpos(URL::previous(), route('expense.index')) !== false)
        <a class="btn btn-primary" href="{{ URL::previous() }}"><i class="bx bx-arrow-back"></i> Voltar</a>
    @else
        <a class="btn btn-primary" href="{{ route('expense.index') }}"><i class="bx bx-arrow-back"></i> Voltar</a>
    @endif
@endsection

<div class="modal fade" id="imgModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" title="Fechar">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Imagem ampliada</h4>
            </div>
            <div class="modal-body">
                <div><img class="img-thumbnail max-75vh" id="recebe-image"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>
@section('scripts')
    <!-- Select2 -->
    <script src="/bower_components/AdminLTE/plugins/select2/select2.full.min.js"></script>
    <script src="{{ url('/js/jQueryRotate.js') }}"></script>
    <script nonce="{{ csp_nonce() }}">
        $(function () {
            //Initialize Select2 Elements
            $(".select2").select2({
                allowClear: true,
                width: "100%"
            });
        });

        var value = 0;
        $(".rotate-image").rotate({

            bind: {
                click: function () {

                    let image = $(this).data("image");
                    let rotate = $(this).data("rotate");
                    let imageId = $(this).data("id");
                    let this2 = $(this);
                    let _token = $('meta[name="csrf-token"]').attr('content');

                    $.ajax({
                        type: 'POST',
                        url: '{{ url("/admin/helper/rotate") }}',
                        data: {
                            image: image,
                            rotate: rotate,
                            _token: _token
                        },
                        // data: "image=" + image + "&rotate=" + rotate,
                        beforeSend: function () {
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

        $(document).on("click", ".removeImage", function (e) {
            e.preventDefault();
            var status = confirm("Deseja realmente remover essa Imagem?");
            if (status == false) {
                return false;
            }
            var id = $(this).data("id");
            var url = $(this).data("url");
            var this2 = $(this);
            let _token = $('meta[name="csrf-token"]').attr('content');

            jQuery.ajax({
                type: 'POST',
                url: '{{route("expense.remove_photo")}}',
                data: {
                    id: id,
                    url: url,
                    _token: _token
                },
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

        $(document).on("click", ".open-modal-img", function () {
            let image = $(this).data("image");
            $("#recebe-image").attr("src", image);
        });


    </script>
@endsection
