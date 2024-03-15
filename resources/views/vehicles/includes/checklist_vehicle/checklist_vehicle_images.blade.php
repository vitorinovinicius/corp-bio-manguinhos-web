@if($vehicleChecklistBasic->checklist_vehicle_images->count())
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="box-title">Imagens</h3>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <div class="row" >
                        @forelse($vehicleChecklistBasic->checklist_vehicle_images as $checklistVehicleImage)
                            <div class="col-3 text-center image">
                                <img src="{{$checklistVehicleImage->url}}"
                                    style="display: block; max-width: 100%; height:auto;"
                                    class="img-responsive cursor-pointer open-modal-img"
                                    id="image-rotate-{{$checklistVehicleImage->id}}"
                                    data-toggle="modal" data-target="#imgModal"
                                    data-image="{{$checklistVehicleImage->url}}"
                                >
                                @if ($checklistVehicleImage->type_id == 0)
                                    <b>Imagem do veículo</b>
                                @endif
                                @if ($checklistVehicleImage->type_id == 1)
                                    <b>Selfie do Supervisor</b>
                                @endif
                                @if ($checklistVehicleImage->type_id == 2)
                                    <b>Assinatura do Supervisor</b>
                                @endif
{{--                                <p>--}}
{{--                                <div style="word-break: break-all;">{{$checklistVehicleImage->reference}}</div>--}}
                                <div>

                                    <a href="{{$checklistVehicleImage->url}}" class="btn btn-link" target="_blank">Abrir externamente
                                        <i class="bx bx-share"></i>
                                    </a>
                                </div>
                            </div>
                        @empty
                            <div class="col-2 text-center">
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
