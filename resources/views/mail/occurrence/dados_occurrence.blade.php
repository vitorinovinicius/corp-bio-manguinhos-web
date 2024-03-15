<div class="row">
    <div class="col-md-12">
        <div class="box box-solid box-danger">
            <div class="box-header">
                <h3 class="box-title">Dados da Ocorrência</h3>
            </div>
            <div class="box-body">
                <!-- Dados do Cliente -->
                <div class="clearfix"></div>
                @include("mail.occurrence.includes.dados_cliente")
                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-solid box-default">
                            <div class="box-header">
                                <h3 class="box-title">Detalhes da Ocorrência</h3>
                            </div>
                            <div class="box-body">

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group col-md-2">
                                            <label for="occurrence_client_id">Status da Ocurrência</label>
                                            <h3>
                                                <span class='label  {{$occurrence->statusLabel()}}'>{{$occurrence->getStatus()}}</span>
                                            </h3>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group col-md-3">
                                            <label for="os_before">Número OS</label>
                                            <div class="input-static">{{ optional($occurrence->occurrence_data_basic)->numero_os }}</div>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label for="occurrence_os_name">Nome da OS</label>
                                            <div class="input-static">{{optional($occurrence->occurrence_data_basic)->nome_os}}</div>
                                        </div>
                                    </div>
                                </div>

                                {{--DATAS--}}
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group col-md-6">
                                            <label for="occurrence_client_id">Técnico</label>
                                            <div class="input-static">
                                                @if(isset($occurrence->operator))
                                                    {{$occurrence->operator->name}}
                                                @else
                                                    Sem técnico associado
                                                @endif
                                            </div>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label>Agendado</label>
                                            <div class="input-static">
                                                {{date('d/m/Y', strtotime($occurrence->schedule_date))}}
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group col-md-12">
                                            <label for="obs_ot">Observações gerais</label>
                                            <div class="input-static">{!! nl2br($occurrence->obs_os) !!}</div>
                                        </div>
                                    </div>
                                    @if($occurrence->status == 3)
                                        <div class="col-md-12">
                                            @if($occurrence->status = 3)  @else
                                                <hr> @endif
                                            <div class="form-group col-md-12" {{($occurrence->status == 3)? "style=display:block;" : "style=display:none;"}}>
                                                <label for="occurrence_client_id">Motivo</label>
                                                <div class="input-static">{{optional($occurrence->nao_realizado_status)->name}}</div>
                                            </div>
                                            <div class="form-group col-md-12" {{($occurrence->status == 3)? "style=display:block;" : "style=display:none;"}}>
                                                <label for="occurrence_client_id">Descrição do motivo</label>
                                                <div class="input-static">{{null_or_na($occurrence->motivo_nao_realizacao)}}</div>
                                            </div>
                                        </div>
                                    @endif
                                    <div class="col-md-12 padding-0">
                                        <div class="form-group col-md-4">
                                            <label for="assinatura">Assinatura do cliente</label>
                                            <div>
                                                @if(!empty($occurrence->assinatura))
                                                    <img src="data:image/jpeg;base64,{{ base64_encode(@file_get_contents(url($occurrence->assinatura))) }}" alt="" class="img-responsive">
                                                @else
                                                    <p class="input-static">Sem assinatura registrado</p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-md-12">
                        @include('occurrences.includes.occurrence_data_client')
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
