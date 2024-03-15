@if($occurrence->alerts->count() > 0)
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="box-title">Alertas</h3>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        @if(count($occurrence->alerts))
                            <div class="table-responsive">
                                <table class="table table-condensed table-striped table-bordered table-sm table-hover">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Alerta</th>
                                        <th>Status</th>
                                        <th>TIPO</th>
                                        <th class="text-right">Opções</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($occurrence->alerts as $alert)
                                        <tr>
                                            <td>{{$alert->id}}</td>
                                            <td>{{$alert->detail}}</td>
                                            <td>{{$alert->treated_date ? "Fechado" : "Aberto"}}</td>
                                            <td>{{$alert->types()}}</td>
                                            <td class="text-right">
                                                <a href="{{route("alerts.show_document", $alert->uuid)}}" class="btn btn-icon btn-sm btn-primary" data-toggle="tooltip" data-placement="left" title="Exibir"><i class="bx bx-book-open"></i></a>
                                            </td>
                                        </tr>
                                    @empty
                                        <h3 class="text-center alert alert-info">Sem alertas</h3>
                                    @endforelse
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <h3 class="text-center alert alert-info">Vazio!</h3>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
