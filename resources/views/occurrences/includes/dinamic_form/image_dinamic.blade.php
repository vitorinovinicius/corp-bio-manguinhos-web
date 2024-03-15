@empty($image)
    @if($occurrence->occurrence_images->where('form_field_id',$field["id"])->where('position',$form_position)->count() > 0)

        <div class="col-12">
            <div class="row">
                <div class="col-12">
                    <p class="box-title">Imagens:</p>
                </div>
            </div>
            <div class="row">
                @foreach($occurrence->occurrence_images->where('form_field_id',$field['id'])->where('position',$form_position) as $imagems3)
                    <div class="col-2 text-center">
                        <img src="{{$imagems3->url}}"
                             style="display: block; max-width: 100%; height:auto;"
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
                @endforeach
            </div>
        </div>
    @endif
@endempty
