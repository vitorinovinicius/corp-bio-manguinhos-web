@if($vehicle->archives()->count())
<meta name="_token" content="{!! csrf_token() !!}"/>
<div class="row page-break" xmlns="http://www.w3.org/1999/html">
    <div class="col-md-12">
        <div class="box box-solid box-danger">
            <div class="box-header">
                <h3 class="box-title">Imagens do veículo</h3>

                <div class="box-tools pull-right hidden-print">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse">
                        <i class="bx bx-minus"></i>
                    </button>
                </div>
            </div>
            <div class="box-body occurrence-description">
                <div class="well col-md-12">
                    <div class="form-group">
                        @forelse($vehicle->archives as $fotos)
                            <div class="col-md-2 text-center">
                                <img src="{{$fotos->url}}" alt="" class="img-responsive">
                                <div>
                                    <a href="{{$fotos->url}}" class="btn btn-link" target="_blank">Abrir externamente
                                        <i class="bx bx-share-square-o"></i>
                                    </a>
                                </div>

                                </p>
                                @is(['superuser','admin'])
                                <a href="#" class="btn btn-danger removeImage" title="Remover arquivo" data-id="{{$fotos->id}}" data-url="{{ $fotos->url }}"><i class="bx bx-trash-o"></i></a>
                                @endis
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
