@if($occurrence->moves->count())
<div class="row">
    <div class="col-12">
        <div class="table-responsive">
            <table class="table table-condensed table-striped  table-sm">
                <thead>
                <tr>
                    <th  style="text-align: left">Tipo Movimentação</th>
                    <th>Mapa</th>
                    <th>Data Checkin</th>
                    <th>Tempo Decorrido</th>
                    <th>Data Comunicação</th>
                </tr>
                </thead>

                <tbody>
                @foreach($occurrence->moves as $move)
                    <tr>
                        <td  style="text-align: left">{{$move->move_type->name}}</td>
                        <td>
                            <a href="https://www.google.com/maps/?q={{$move->check_in_lat}},{{$move->check_in_long}}" class="btn btn-info btn-xs" target="_blank"><i class="bx bx-share"></i>Ver no Maps</a>
                        </td>
                        <td>{{null_or_na($move->dateCheckin())}}</td>
                        <td>
                            @if ($move->move_type_id == 5)
                                {{tmpDeslocamento($move->occurrence, 4, 5)}}
                            @elseif ($move->move_type_id == 7)
                                {{tmpDeslocamento($move->occurrence, 6, 7)}}
                            @else
                                ---
                            @endif
                        </td>
                        <td>{{null_or_na($move->dateCreated())}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@else
    <h3 class="text-center alert alert-info">Vazio!</h3>
@endif

<div class="row">
    <div class="col-12">

        @if(!empty($latIni) && !empty($latFim) && !empty($longIni) && !empty($longFim))
            <div class="form-group">
                <iframe width="100%" height="250" frameborder="0" style="border:0"
                        src="https://www.google.com/maps/embed/v1/directions?origin={{$latIni}},{{$longIni}}&destination={{$latFim}},{{$longFim}}&key={{env('GOOGLE_MAPS_KEY')}}" allowfullscreen></iframe>
            </div>
        @endif

    </div>
</div>

