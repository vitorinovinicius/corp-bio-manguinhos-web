@if($operator->checklist_vehicles->count())
    <div class="table-responsive">
        <table class="table table-condensed table-striped table-sm table-hover" data-page-length='50'>
            <thead>
            <tr>
                <th>Tipo</th>
                <th>Condutor</th>
                <th>Avaliador</th>
                <th>Data</th>
                <th class="text-right">OPÇÕES</th>
            </tr>
            </thead>

            <tbody>
                @foreach($operator->checklist_vehicles as $vehicleChecklistBasic)
                    <tr>
                        <td>{{tipoVeiculo($vehicleChecklistBasic->type_id)}}</td>
                        <td>{{optional($vehicleChecklistBasic->condutor)->name}}</td>
                        <td>{{$vehicleChecklistBasic->avaliador}}</td>
                        <td>{{\Carbon\Carbon::parse($vehicleChecklistBasic->created_at)->format("d/m/Y")}}</td>
                        <td  class="text-right">
                            @shield('vehicles.checklist')
                            <a href="{{ route('vehicles.checklist.show', $vehicleChecklistBasic->uuid) }}" class="btn btn-icon btn-sm btn-primary" data-toggle="tooltip" data-placement="left" title="Exibir"><i class="bx bx-book-open"></i></a>
                            @endshield
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endif
