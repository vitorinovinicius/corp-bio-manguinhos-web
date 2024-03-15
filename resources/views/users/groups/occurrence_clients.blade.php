<div class="row">
    <div class="col-12">        
        <div class="card">
            <div class="card-header">               
                <div class="row">
                    <div class="col-4">
                        <h4 class="box-title">Clientes associadas</h4>
                    </div>
                   
                    <div class="col-8 d-flex justify-content-end align-items-center">
                        @shield('groups.create')
                        <a class="btn btn-primary pull-right" href="{{route('users.associate.occurrence_clients', $group->uuid)}}"><i class="bx bx-plus"></i> Associar Cliente</a>
                        <a href="#" class="btn btn-warning pull-right" id="btn-attr-occurrence-client"><i class="bx bx-minus"></i> Desassociar Cliente</a>
                        @endis
                    </div>
                </div>
            </div>
            <div class="card-content">
                <div class="card-body">
                    @if($group->occurrence_clients->count())
                        <div class="table-responsive">
                            <table class="table table-condensed table-striped table-sm table-hover tb-occurrence-clients">
                                <thead>
                                <tr>
                                    <th><input type="checkbox" id="check_all_clients" class="cs_checkbox"></th>
                                    <th>ID</th>
                                    <th>Nome</th>
                                    <th class="text-right">Opções</th>
                                </tr>
                                </thead>
                                <tbody>
                                    <!-- Listar -->
                                    @foreach ($group->occurrence_clients as $occurrence_client)
                                        <tr>
                                            <td>
                                                <input name="ids[]" class="ids_check_clients cs_checkbox" type="checkbox" value="{{$occurrence_client->id}}">
                                            </td>
                                            <td>{{$occurrence_client->id}}</td>
                                            <td>{{$occurrence_client->name}}</td>
                                            <td class="text-right">
                                                @shield('occurrence_clients')
                                                <a href="{{ route('occurrence_clients.show', $occurrence_client->uuid) }}" class="btn btn-icon btn-sm btn-primary" data-toggle="tooltip" data-placement="left" title="Exibir"><i class="bx bx-book-open"></i></a>
                                                @endshield
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="col-md-12">Nenhuma cliente associado</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
