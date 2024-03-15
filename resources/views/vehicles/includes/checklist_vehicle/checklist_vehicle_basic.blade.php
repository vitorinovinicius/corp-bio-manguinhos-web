@if($vehicleChecklistBasic)
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="box-title">Dados básicos</h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-3">
                                <div class="form-group">
                                    <label>Tipo</label>
                                    <p class="form-control-static" >{{tipoVeiculo($vehicleChecklistBasic->type_id)}}</p>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label>Condutor</label>
                                    <p class="form-control-static" >{{$vehicleChecklistBasic->condutor->name}}</p>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label>Avaliador</label>
                                    <p class="form-control-static" >{{$vehicleChecklistBasic->avaliador}}</p>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label>Data</label>
                                    <p class="form-control-static" >{{\Carbon\Carbon::parse($vehicleChecklistBasic->created_at)->format("d/m/Y")}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include("vehicles.includes.checklist_vehicle.checklist_vehicle")
    @include("vehicles.includes.checklist_vehicle.checklist_vehicle_images")
@endif
