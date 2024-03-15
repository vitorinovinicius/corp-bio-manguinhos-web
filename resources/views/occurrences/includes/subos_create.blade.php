@if($occurrence)
    <input type="hidden" name="os_before_id" value="{{ $occurrence->id }}">

    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="box-title">OS Principal - {{$occurrence->numero_os}}</h3>
            </div>
            <div class="card-content">
                <div class="card-body">
                    <div class="row">
                        <div class="col-2">
                            <div class="form-group">
                                <label>Status da OS</label>
                                <p class="form-control-static {{$occurrence->statusLabel()}}" >{{$occurrence->getStatus()}}</p>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-group">
                                <label>Número OS</label>
                                <p class="form-control-static" >{{ $occurrence->numero_os }}</p>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label>Empreiteira</label>
                                <p class="form-control-static" >{{ $occurrence->contractor->name }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <div class="form-group">
                                <label>Nome da Ocorrência</label>
                                <p class="form-control-static" >{{optional($occurrence->occurrence_type)->name}}</p>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-group">
                                <label>Técnico</label>
                                <p class="form-control-static" >
                                    @if(isset($occurrence->operator))
                                        {{$occurrence->operator->name}}
                                    @else
                                        Sem técnico associado
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endif
