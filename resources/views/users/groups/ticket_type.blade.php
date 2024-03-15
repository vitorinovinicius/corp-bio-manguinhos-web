<div class="row">
    <div class="col-12">        
        <div class="card">
            <div class="card-header">               
                <div class="row">
                    <div class="col-4">
                        <h4 class="box-title">Ticket do grupo de usuários</h4>
                    </div>
                    <div class="col-8 d-flex justify-content-end align-items-center">
                        @shield('groups.create')
                        <a class="btn btn-primary pull-right" href="{{route('ticket_types.create', $group->uuid)}}"><i class="bx bx-plus"></i> Criar tipo ticket</a>
                        @endis
                    </div>              
                </div>
            </div>
            <div class="card-content">
                <div class="card-body">
                    @if($group->ticketTypes->count())
                        <div class="table-responsive">
                            <table class="table table-condensed table-striped table-sm table-hover tb-occurrence-clients">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nome</th>
                                    <th>Descricão</th>
                                    <th class="text-right">Opções</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach ($group->ticketTypes as $ticketType)
                                    <tr>                                       
                                        <td>{{$ticketType->id}}</td>
                                        <td>{{$ticketType->name}}</td>
                                        <td>{{$ticketType->description}}</td>
                                        <td class="text-right">
                                            @shield('groups.show')
                                            <a href="{{ route('ticket_types.show', $ticketType->uuid) }}" class="btn btn-icon btn-sm btn-primary" data-toggle="tooltip" data-placement="left" title="Exibir"><i class="bx bx-book-open"></i></a>
                                            @endshield
                                            @shield('groups.edit')
                                                <a href="{{ route('ticket_types.edit', $ticketType->uuid) }}" class="btn btn-icon btn-sm btn-warning" data-toggle="tooltip" data-placement="left" title="Editar"><i class="bx bx-pencil"></i></a>
                                            @endshield
                                                @shield('groups.destroy')
                                                <form action="{{ route('teams.destroy', $ticketType->uuid) }}"
                                                      method="POST" style="display: inline;"
                                                      onsubmit="if(confirm('Deseja deletar esse item?')) { return true } else {return false };">
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                    <button type="submit" class="btn btn-icon btn-sm btn-danger" data-toggle="tooltip" data-placement="left" title="Deletar"><i class="bx bx-trash"></i></button>
                                                </form>
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
