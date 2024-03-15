<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-4">
                        <h4 class="box-title">Zonas associadas</h4>
                    </div>
                    <div class="col-8 d-flex justify-content-end align-items-center">
                        @shield('operator.create')
                        <a class="btn btn-primary pull-right" href="{{ route('users.associate.zone', $operator->uuid) }}"><i class="bx bx-plus"></i> Associar zona</a>
                        <a href="{{ route('users.desassociate.zone', $operator->uuid) }}" class="btn btn-warning pull-right"><i class="bx bx-minus"></i> Desassociar zonas</a>
                        @endis
                    </div>
                </div>
            </div>
            <div class="card-content">
                <div class="card-body">
                    @if($operator->zones->count())
                        <div class="table-responsive">
                            <table class="table table-condensed table-striped table-sm table-hover">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Zona</th>
                                    <th class="text-right">Opções</th>
                                </tr>
                                </thead>
                                <tbody>

                                <!-- Listar -->
                                @foreach ($operator->zones as $zone)

                                    <tr>
                                        <td>{{$zone->id}}</td>
                                        <td>{{$zone->zone}}</td>
                                        <td class="text-right">
                                            @shield('zones.show')
                                            <a href="{{ route('zones.show', $zone->uuid) }}" class="btn btn-icon btn-sm btn-primary" data-toggle="tooltip" data-placement="left" title="Exibir"><i class="bx bx-book-open"></i></a>
                                            @endshield

                                        </td>
                                    </tr>

                                @endforeach

                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="col-md-12">Nenhuma zona associada</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
