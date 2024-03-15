@if($occurrence->occurrence_images->where('form_id',null)->count())
    <div class="row">
        <div class="col-md-12">
            <div class="box box-solid box-danger">
                <div class="box-header">
                    <h3 class="box-title">Imagens finais ({{$occurrence->occurrence_images->where('form_id',null)->count()}})</h3>

                    <div class="box-tools pull-right hidden-print">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse">
                            <i class="bx bx-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="box-body occurrence-description">
                    <div class="well col-md-12">
                        <div class="form-group">
                            @forelse($occurrence->occurrence_images->where('form_id',null) as $imagems3)
                                    <div class="col-md-2 text-center">
                                        <img src="data:image/jpeg;base64,{{ base64_encode(@file_get_contents(url($imagems3->url))) }}" class="img-responsive cursor-pointer open-modal-img" id="image-rotate-{{$imagems3->id}}" data-toggle="modal" data-target="#imgModal" data-image="data:image/jpeg;base64,{{ base64_encode(@file_get_contents(url($imagems3->url))) }}">
                                        <p>
                                        <div style="word-break: break-all;">{{$imagems3->reference}}</div>

                                    </div>
                            @empty
                                <div class="col-md-2 text-center">
                                    <p>Não há mais imagens</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
