@if($operator->workday)
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="box-title">Joranada de trabalho</h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <h5>{{$operator->workday->name}}</h5>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-condensed table-striped table-sm table-hover">
                                <thead>
                                <tr>
                                    <th>Dia da semana</th>
                                    <th>Horas de trabalho</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if($operator->workday->workday_programs)
                                    @foreach($operator->workday->workday_programs as $program)
                                        <tr>
                                            <td>{{weekDay($program->day)}}</td>
                                            <td>{{$program->hour}}</td>
                                        </tr>
                                    @endforeach
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
