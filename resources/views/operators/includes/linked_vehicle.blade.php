<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="box-title">Veículo vinculado</h4>
            </div>
            <div class="card-content">
                <div class="card-body">
                    @if($operator->vehicle)
                        <div class="row">
                            <div class="col-4 form-group">
                                        <label for="foto">Tipo</label>
                                <p class="form-control-static">{{optional($operator->vehicle)->types()}}</p>
                            </div>
                            <div class="col-4 form-group">
                                        <label for="foto">Placa</label>
                                <p class="form-control-static">{{optional($operator->vehicle)->placa}}</p>
                            </div>
                            <div class="col-4 form-group">
                                        <label for="foto">Modelo</label>
                                <p class="form-control-static">{{optional($operator->vehicle)->model}}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-4 form-group">
                                        <label for="foto">Chassi</label>
                                <p class="form-control-static">{{optional($operator->vehicle)->chassi}}</p>
                            </div>
                            <div class="col-4 form-group">
                                        <label for="foto">Ano</label>
                                <p class="form-control-static">{{optional($operator->vehicle)->year}}</p>
                            </div>
                            <div class="col-4 form-group">
                                        <label for="foto">Data Documento</label>
                                <p class="form-control-static">{{\Carbon\Carbon::parse(optional($operator->vehicle)->document_date)->format("d/m/Y")}}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-4 form-group">
                                        <label for="foto">Vencimento</label>
                                <p class="form-control-static">{{\Carbon\Carbon::parse(optional($operator->vehicle)->due_date)->format("d/m/Y")}}</p>
                            </div>
                        </div>
                    @else
                        <div class="col-md-12">Nenhum veículo vinculado</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
