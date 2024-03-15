<div class="row">
    <div class="col-12">
        @include('messages')
        @include('error')
        <div class="card">
            <div class="card-header">               
                <div class="row">
                    <div class="col-4">
                        <h4 class="box-title">Usuarios associadas</h4>
                    </div>
                   
                    <div class="col-8 d-flex justify-content-end align-items-center">
                        @shield('groups.create')
                        <a class="btn btn-primary pull-right" href="{{route('users.associate', $group->uuid)}}"><i class="bx bx-plus"></i> Associar Usuário</a>
                        <a href="#" class="btn btn-warning pull-right" id="btn-attr-user"><i class="bx bx-minus"></i> Desassociar Usuário</a>
                        @endis
                    </div>
                </div>
            </div>
            <div class="card-content">
                <div class="card-body">
                    @if($group->users->count())
                        <div class="table-responsive">
                            <table class="table table-condensed table-striped table-sm table-hover tb-users">
                                <thead>
                                <tr>
                                    <th><input type="checkbox" id="check_all_users" class="cs_checkbox"></th>
                                    <th>ID</th>
                                    <th>Nome</th>
                                    <th class="text-right">Opções</th>
                                </tr>
                                </thead>
                                <tbody>

                                <!-- Listar -->
                                @foreach ($group->users as $user)

                                    <tr>
                                        <td>
                                            <input name="ids[]" class="ids_check_users cs_checkbox" type="checkbox" value="{{$user->id}}">
                                        </td>
                                        <td>{{$user->id}}</td>
                                        <td>{{$user->name}}</td>
                                        <td class="text-right">
                                            @shield('users.show')
                                            <a href="{{ route('users.show', $user->uuid) }}" class="btn btn-icon btn-sm btn-primary" data-toggle="tooltip" data-placement="left" title="Exibir"><i class="bx bx-book-open"></i></a>
                                            @endshield

                                        </td>
                                    </tr>

                                @endforeach

                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="col-md-12">Nenhuma usuário associado</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
