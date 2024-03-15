@if($trackingCollection->count())
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="box-title">Conectividade</h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-condensed table-striped table-sm">
                                <thead>
                                <tr>
                                    <th>Latitude</th>
                                    <th>Longitude</th>
                                    <th>Mapa</th>
                                    <th>Tipo de Conexão</th>
                                    <th>Data Comunicação</th>
                                    <th>Bateria</th>
                                    @is(['superuser'])
                                    <th>Connect</th>
                                    <th>Versão</th>
                                    <th>Sdk</th>
                                    <th>Disp</th>
                                    <th>IP</th>
                                    @endis
                                </tr>
                                </thead>

                                <tbody>
                                @foreach($trackingCollection as $track)
                                    <tr>
                                        <td>{{$track->latitude}}</td>
                                        <td>{{ $track->longitude }}</td>
                                        <td>
                                            <a href="https://www.google.com/maps/?q={{$track->latitude}},{{$track->longitude}}"
                                               class="btn btn-info btn-xs" target="_blank"><i class="bx bx-share"></i>Ver no
                                                Maps</a>
                                        </td>
                                        <td>{{ $track->tipo_conexao }}</td>
                                        <td>{{ date('d/m/Y H:i:s', strtotime($track->created_at)) }}</td>
                                        <td>{{ $track->battery }}</td>
                                        @is(['superuser'])
                                        <td>
                                            {{ $track->isConnect }}
                                            @is(['superuser'])
                                            @if($track->observacao)
                                                <span class="bx bx-info-sign"
                                                      title="{{$track->observacao}}"></span>@endif
                                            @endis
                                        </td>
                                        <td><span title="Versão Android">{{ $track->version_release }}</span> -
                                            <span title="CS Versão">{{$operator->device_version}}</span></td>
                                        <td>
                                            <span title="Device Version Number"> {{ $track->device_version_number }}</span>
                                            -
                                            <span title="SDK versão"> {{$track->version_sdk_int}}</span></td>
                                        <td><span title="Espaço disponível"> {{ $track->last_size }}</span></td>
                                        <td><span title="IP"> {{ $track->ip }}</span></td>
                                        @endis

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
