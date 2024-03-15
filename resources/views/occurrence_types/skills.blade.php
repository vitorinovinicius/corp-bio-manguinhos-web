<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-8">
                        <h3 class="box-title">Habilidades associadas</h3>
                    </div>
                    <div class="col-4 d-flex justify-content-end align-items-center">

                        @shield('occurrence_type.create')
                        <a class="btn btn-primary" href="{{ route('occurrence_types.associate.skill', $occurrence_type->uuid) }}"><i class="bx bx-plus"></i> Associar Habilidades</a>
                        <a  class="btn btn-warning pull-right" href="{{ route('occurrence_types.desassociate.skill', $occurrence_type->uuid) }}"><i class="bx bx-minus"></i> Desassociar habilidades</a>
                        @endis
                    </div>
                </div>

            </div>
            <div class="card-content">
                <div class="card-body">
                    <div class="row">
                        @if($occurrence_type->skills->count())
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

                                    <!-- Listar os contratos abaixo -->
                                    @foreach ($occurrence_type->skills as $skill)

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
</div>
