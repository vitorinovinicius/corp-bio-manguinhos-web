@if($operator->teams)
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="box-title">Equipes</h3>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        @foreach($operator->teams->unique() as $team)
                            <div class="row">
                                <div class="col-12">
                                    <h5>{{$team->name}}</h5>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-condensed table-striped table-sm table-hover">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nome</th>
                                        <th>email</th>
                                        <th>Tipo</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    @foreach($team->users()->distinct()->get() as $operator2)
                                        <tr>
                                            <td>{{$operator2->id}}</td>
                                            <td>{{$operator2->name}}</td>
                                            <td>{{$operator2->email}}</td>
                                            <td>
                                                @foreach($operator2->user_teams()->where("team_id","=",$team->id)->get() as $user_team)
                                                    <span class="badge badge-primary">{{($user_team->is_supervisor == 1 ? "Supervisor" : "Operador")}}</span>
                                                @endforeach
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
