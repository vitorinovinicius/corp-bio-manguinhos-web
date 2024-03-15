@if($occurrence->interferences->count())
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="box-title">Interferências</h3>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm table-hover table-striped">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Descrição</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($occurrence->interferences as $interference)
                                    <tr>
                                        <td>{{ $interference->id }}</td>
                                        <td>{{ $interference->description }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
