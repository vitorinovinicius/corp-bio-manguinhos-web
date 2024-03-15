@if($occurrence->status == 1)
    @if($occurrence->smses->count())
        @if( (abs( strtotime($occurrence->smses->last()->created_at) - time() ) / 60) < 180)
            <div class="row">
                <div class="col-md-12">
                    <div class="card ">
                        <div class="card-content">
                            <div class="card-header">
                                <h3 class="card-title">Atendimento</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="callout callout-info">
                                            <h4>Atenção!!</h4>
                                            Esse link irá espirar assim que o técnico terminar o atendimento ou até às
                                            <strong>{{\Carbon\Carbon::parse($occurrence->smses->last()->created_at)->addHour(3)->format("H:i:s")}}</strong>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card">
                                            <div class="card-header">
                                                <h3 class="card-title">Dados da empresa</h3>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">

                                                    @if($occurrence->contractor->logo_cabecalho)
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <img class="img-thumbnail cs_logo_tracert" src="{{ $occurrence->contractor->logo_cabecalho }}">
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="row">
                                                    <div class="form-group col-md-2">
                                                        <img class="img-thumbnail img-bordered" src="{{ $occurrence->operator->foto ? : "/img/techinical.png" }}">
                                                    </div>
                                                    <div class="col-md-10">
                                                        <div class="row">
                                                            <div class="form-group col-md-4">
                                                                <label>Nome col-md-aborador</label>
                                                                <div class="input-static">{{$occurrence->operator->name}}</div>
                                                            </div>
                                                            <div class="form-group col-md-4">
                                                                <label>Empresa</label>
                                                                <div class="input-static">{{$occurrence->operator->ecc}}</div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="form-group col-md-6">
                                                                <label>Tipo de Ordem de Serviço</label>
                                                                <div class="input-static">{{optional($occurrence->occurrence_type)->name}}</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                                @include('occurrences.includes.dados_cliente')

                                @if(!empty($traking["client_lat"]) AND !empty($traking["client_lng"]))
                                    <div class="card card-solid card-default">
                                        <div class="card-header">
                                            <h3 class="card-title">Dados da Localização</h3>
                                        </div>
                                        <div class="card-body">

                                            @include("occurrences.includes.client.dados_mapa")

                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="card card-solid card-danger ">
                <div class="card-header">
                    <h3 class="card-title">Atendimento</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <h2 class="panel-title">Link expirado!</h2>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @else
        <div class="card card-solid card-danger ">
            <div class="card-header">
                <h3 class="card-title">Atendimento</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <h2 class="panel-title">Não há exibição, SMS não pode ser enviado!</h2>
                    </div>
                </div>
            </div>
        </div>
    @endif
@else
    <div class="card card-solid card-danger ">
        <div class="card-header">
            <h3 class="card-title">Atendimento</h3>
        </div>
        <div class="card-body">

            <div class="row">
                <div class="col-md-12">
                    <h2 class="panel-title">Ordem de serviço já finalizada.</h2>
                </div>
            </div>
        </div>
    </div>
@endif
