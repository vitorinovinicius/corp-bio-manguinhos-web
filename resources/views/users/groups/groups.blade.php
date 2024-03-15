<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-4">
                        <h4 class="box-title">Grupos associados</h4>
                    </div>
                    <div class="col-8 d-flex justify-content-end align-items-center">
                        @shield('operator.create')
                        <a class="btn btn-primary pull-right" href="{{ route('groups.associate', $user->uuid) }}"><i class="bx bx-plus"></i> Associar Grupos</a>
                        <a href="#" class="btn btn-warning pull-right" id="btn-attr-group"><i class="bx bx-minus"></i> Desassociar Usuário</a>
                        @endis
                    </div>
                </div>
            </div>
            <div class="card-content">
                <div class="card-body">
                    @if($user->groups->count())
                        <div class="table-responsive">
                            <table class="table table-condensed table-striped table-sm table-hover tb-groups">
                                <thead>
                                <tr>
                                    <th><input type="checkbox" id="check_all_groups" class="cs_checkbox"></th>
                                    <th>ID</th>
                                    <th>Nome</th>
                                    <th class="text-right">Opções</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach ($user->groups as $group)

                                        <tr>
                                            <td>
                                                <input name="ids[]" class="ids_check_groups cs_checkbox" type="checkbox" value="{{$group->id}}">
                                            </td>
                                            <td>{{$group->id}}</td>
                                            <td>{{$group->name}}</td>
                                            <td class="text-right">
                                                @shield('groups.show')
                                                <a href="{{ route('groups.show', $group->uuid) }}" class="btn btn-icon btn-sm btn-primary" data-toggle="tooltip" data-placement="left" title="Exibir"><i class="bx bx-book-open"></i></a>
                                                @endshield
                                                @shield('users.update')
                                                {{-- <form action="{{ route('users.disassociate.client.store', $user->uuid) }}"
                                                      method="POST" style="display: inline;"
                                                      onsubmit="if(confirm('Deseja deletar esse item?')) { return true } else {return false };">
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                    <input type="hidden" name="occurrence_client_id" value="{{ $user->id }}">
                                                    <button type="submit" class="btn btn-icon btn-sm btn-danger" data-toggle="tooltip" data-placement="left" title="Deletar"><i class="bx bx-trash"></i></button>
                                                </form> --}}
                                                @endshield

                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="col-md-12">Nenhum grupo associado</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
