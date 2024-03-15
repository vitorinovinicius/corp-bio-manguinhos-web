@if($occurrence->status == 2 || $occurrence->status == 3)
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="box-title">Dados do atendimento - Informações</h3>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Tempo de execução</label>
                                    <p class="form-control-static">{{(!empty($occurrence->check_in && !empty($occurrence->check_out))) ? calcula_minutos($occurrence->check_in,$occurrence->check_out) : "-"}}</p>
                                </div>
                            </div>
                            @if($occurrence->status == 2)
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Observações gerais</label>
                                        <p class="form-control-static">{!! nl2br($occurrence->obs_os) !!}</p>
                                    </div>
                                </div>
                            @endif
                            @if($occurrence->status == 3)
                                <hr>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Motivo</label>
                                        <p class="form-control-static">{{optional($occurrence->nao_realizado_status)->name}}</p>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Descrição do motivo</label>
                                        <p class="form-control-static">{{null_or_na($occurrence->motivo_nao_realizacao)}}</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    @if(!empty($occurrence->signature_type) AND $occurrence->signature_type == "AUDIO_ASSINATURA")
                                        <label>Assinatura em Audio do Cliente</label>

                                        @if(!empty($occurrence->signature_type))
                                            @php
                                                $assinaturaAudio = $occurrence->occurrence_archives->where('type_file',1)->first();
                                            @endphp
                                            @if($assinaturaAudio)
                                                <p class="form-control-static">
                                                    <a href="{{$assinaturaAudio->url}}" class="btn btn-link" target="_blank">
                                                        Abrir externamente <i class="bx bx-share"></i>
                                                    </a>
                                                </p>
                                            @endif
                                        @else
                                            <p class="form-control-static">Sem assinatura registrado</p>
                                        @endif
                                    @else
                                        <label>Assinatura do Cliente</label>

                                        @if(!empty($occurrence->assinatura))
                                            <div>
                                                <img src="{{$occurrence->assinatura}}" class="h-100 w-100 rounded-left img-assinatura">
                                                <p class="text-center hidden-pdf">
                                                    <a href="{{$occurrence->assinatura}}" class="btn btn-link" target="_blank">
                                                        Abrir externamente <i class="bx bx-share"></i>
                                                    </a>
                                                </p>
                                            </div>
                                        @else
                                            <p class="form-control-static">Sem assinatura registrado</p>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
