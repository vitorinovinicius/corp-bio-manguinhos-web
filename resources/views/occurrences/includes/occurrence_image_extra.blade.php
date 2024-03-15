@if($occurrence->occurrence_images->where('form_id',null)->where('form_field_id', null)->where('reference', 'foto_extra')->count())
    <meta name="_token" content="{!! csrf_token() !!}"/>

    <div class="card">
        <div class="card-header">
            <h3 class="box-title">Imagens extras
                ({{$occurrence->occurrence_images->where('form_id',null)->count()}})</h3>
        </div>
        <div class="card-content">
            <div class="card-body">
                <div class="row">
                    @empty($image)
                        @forelse($occurrence->occurrence_images->where('form_id',null)->where('form_field_id', null) as $imagems3)
                            <div class="col-2 text-center">
                                <img src="{{$imagems3->url}}"
                                     style="display: block; max-width: 100%; height:auto; margin: 0 auto;"
                                     class="img-responsive cursor-pointer open-modal-img"
                                     id="image-rotate-{{$imagems3->id}}" data-toggle="modal" data-target="#imgModal"
                                     data-image="{{$imagems3->url}}">
                                <div style="word-break: break-all;" class="padding-tb-5">{{$imagems3->reference}}</div>
                                <div class="hidden-pdf">
                                    <a href="{{$imagems3->url}}" class="btn btn-link" target="_blank">
                                        Abrir externamente <i class="bx bx-share"></i>
                                    </a>
                                </div>
                                <div class="hidden-pdf">
                                    @shield('occurrence_image.destroy')
                                    <a href="#" class="btn btn-danger removeImage" title="Remover arquivo"
                                       data-id="{{$imagems3->id}}" data-url="{{ $imagems3->url }}"><i class="bx bx-trash"></i>
                                    </a>
                                    @endshield
                                </div>
                            </div>
                        @empty
                            <div class="col-2 text-center">
                                <p>Não há mais imagens</p>
                            </div>
                        @endforelse
                    @endempty
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="imgModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" title="Fechar">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Imagem ampliada</h4>
                </div>
                <div class="modal-body ">
                    <div class="text-center"><img class="img-thumbnail" id="recebe-image"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>
@endif
@section('scripts')
    <script src="/js/jQueryRotate.js"></script>
    <script>
        $(function () {

            $(document).on("click", ".open-modal-img", function () {
                let image = $(this).data("image");
                console.log("teste");
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
                        })

                        let image = $(this).data("image");
                        let rotate = $(this).data("rotate");
                        let imageId = $(this).data("id");
                        let this2 = $(this);

                        $.ajax({
                            type: 'POST',
                            url: '/admin/helper/rotate',
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

        });
    </script>
@endsection

