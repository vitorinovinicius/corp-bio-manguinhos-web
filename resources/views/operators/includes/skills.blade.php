<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-4">
                        <h4 class="box-title">Habilidades associadas</h4>
                    </div>
                    <div class="col-8 d-flex justify-content-end align-items-center">
                        @shield('operator.create')
                        <a class="btn btn-primary pull-right" href="{{ route('users.associate.skill', $operator->uuid) }}"><i class="bx bx-plus"></i> Associar Habilidades</a>
                        <a href="{{ route('users.desassociate.skill', $operator->uuid) }}" class="btn btn-warning pull-right"><i class="bx bx-minus"></i> Desassociar habilidades</a>
                        @endis
                    </div>
                </div>
            </div>
            <div class="card-content">
                <div class="card-body">
                    @if($operator->skills->count())
                        <div class="table-responsive">
                            <table class="table table-condensed table-striped table-sm table-hover">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nome</th>
                                    <th>Descrição</th>
                                    <th class="text-right">Opções</th>
                                </tr>
                                </thead>
                                <tbody>

                                <!-- Listar -->
                                @foreach ($operator->skills as $skill)

                                    <tr>
                                        <td>{{$skill->id}}</td>
                                        <td>{{$skill->name}}</td>
                                        <td>{{$skill->description}}</td>
                                        <td class="text-right">
                                            @shield('skill.show')
                                            <a href="{{ route('skills.show', $skill->uuid) }}" class="btn btn-icon btn-sm btn-primary" data-toggle="tooltip" data-placement="left" title="Exibir"><i class="bx bx-book-open"></i></a>
                                            @endshield

                                        </td>
                                    </tr>

                                @endforeach

                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="col-md-12">Nenhuma habilidade associada</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
