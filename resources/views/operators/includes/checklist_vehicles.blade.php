@if($operator->checklist_vehicles->count())
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="box-title">Checklist Veículo</h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        @include("operators.includes.checklist_vehicle.checklist_vehicle_basic")
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
