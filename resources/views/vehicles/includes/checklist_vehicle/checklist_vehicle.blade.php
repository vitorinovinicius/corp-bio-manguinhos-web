@if($vehicleChecklistBasic->checklist_vehicles->count())
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="box-title">Checklist</h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        @foreach($vehicleChecklistBasic->checklist_vehicles as $checklistVehicle)
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Item</label>
                                        <p class="form-control-static">{{optional($checklistVehicle->item)->descricao}}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-1">
                                    <div class="form-group">
                                        <label>Situação</label>
                                        <p class="form-control-static">{{sim_nao($checklistVehicle->option_id)}}</p>
                                    </div>
                                </div>
                                @if($checklistVehicle->option_id == 2)
                                    <div class="col-5">
                                        <div class="form-group">
                                            <label>Ação recomendada</label>
                                            <p class="form-control-static">{{$checklistVehicle->acao_recomendada}}</p>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label>Responsável</label>
                                            <p class="form-control-static">{{$checklistVehicle->responsavel}}</p>
                                        </div>
                                    </div>
                                   
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label>Prazo</label>
                                            <p class="form-control-static">{{$checklistVehicle->prazo}}</p>
                                        </div>
                                    </div>
                                    
                                @endif
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <hr>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
