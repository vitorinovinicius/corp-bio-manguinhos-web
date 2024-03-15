@extends('layouts.frest_template')
@section('css')
    <!-- DataTables -->
    <link rel="stylesheet" href="/js/datatables/dataTables.bootstrap.css">
    <link rel="stylesheet" href="/bower_components/AdminLTE/plugins/select2/select2.min.css">
@endsection

@section('content-header')
    <div class="content-header-left col-10 mb-2 mt-1">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h5 class="content-header-title float-left pr-1 mb-0">Técnicos</h5>
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb p-0 mb-0">
                        <li class="breadcrumb-item"><i class="bx bx-home-alt"></i> Home</li>
                        <li class="breadcrumb-item active">Técnicos</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="col-2 d-flex justify-content-end align-items-center">
        @shield('operator.create')
        <a class="btn btn-success pull-right" href="{{ route('operators.create') }}"><i class="bx bx-plus"></i> Novo</a>
        @endshield
    </div>
@endsection

@section('content')
    @include('messages')
    @include('error')

    {{--FILTROS INICIO--}}
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Filtro </h4>
                    <a class="heading-elements-toggle">
                        <i class="bx bx-dots-vertical font-medium-3"></i>
                    </a>
                    <div class="heading-elements">
                        <ul class="list-inline mb-0">
                            <li>
                                <a data-action="collapse">
                                    <i class="bx bx-chevron-down"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="card-content collapse {{app('request')->exists('name') == false ? "" : "show"}}">
                    <div class="card-body">
                        <form class="form form-vertical" method="GET" id="form_export">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="form-body">
                                <div class="row">
                                    @is(['regiao','superuser'])
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label>Empreiteiras</label>
                                            <select class="form-control select2" name="contractor_id" data-placeholder="Selecione o tipo da Ocorrência">
                                                <option></option>
                                                @forelse($contractors as $contractor)
                                                    <option value="{{$contractor->id}}" {{(app('request')->input('contractor_id')==$contractor->id?"selected":"")}}>{{$contractor->name}}</option>
                                                @empty
                                                @endforelse
                                            </select>
                                        </div>
                                    </div>
                                    @endis
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label for="name">Nome</label>
                                            <input class="form-control" type="text" name="name" id="search" placeholder="Nome" value="{{ app('request')->input('name') }}">
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label for="team_id">Equipe</label>
                                            <select class="form-control select2" name="team_id" data-placeholder="Selecione a equipe">
                                                <option></option>
                                                @forelse($teams as $team)
                                                    <option value="{{$team->id}}" {{(app('request')->input('team_id')==$team->id?"selected":"")}}>{{$team->name}} - {{optional($team->users()->wherePivot('is_supervisor',1)->first())->name}}</option>
                                                @empty
                                                @endforelse
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-2">
                                        <div class="form-group">
                                            <label for="team_id">Status</label>
                                            <select class="form-control select2" name="status" data-placeholder="Selecione o status">
                                                <option></option>
                                                <option value="1" {{(app('request')->input('status')==1?"selected":"")}}>Habilitado</option>
                                                <option value="2" {{(app('request')->input('status')==2?"selected":"")}}>Desabilitado</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                @is('superuser')
                                <div class="row">
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label for="name">Versão App</label>
                                            <input class="form-control" type="text" name="device_version" id="search" placeholder="1.1.1" value="{{ app('request')->input('device_version') }}">
                                        </div>
                                    </div>
                                </div>
                                @endis
                                <div class="row">
                                    <div class="col-12 d-flex justify-content-end">
                                            <button type="" class="btn btn-success " id="btnGerar" name="export" value="export"><i class="bx bx-download"></i> Exportar Excel</button>
                                            <button type="submit" class="btn btn-primary " id="btn-external-filter"><i class="bx bx-search"></i> Aplicar</button>
                                            <a href="/{{Route::getCurrentRoute()->uri()}}" class="btn btn-link pull-right"><i class="bx bx-eraser"></i> Limpar</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{--FILTROS FIM--}}

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="box-title">Técnicos ({{$operators->count()}})</h3>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        @if($operators->count())
                            <div class="table-responsive">
                                <table class="table table-condensed table-striped table-sm table-hover" data-page-length='50'>
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nome</th>
                                        <th>Versão</th>
                                        <th>E-mail</th>
                                        <th>Tipo</th>
                                        <th>Equipe</th>
                                        {{--<th>Supervisor</th>--}}
                                        {{--<th>Região</th>--}}
                                        {{--<th>Equipamento</th>--}}
                                        <th>Status</th>
                                        {{--<th>Criado</th>--}}
                                        {{--<th>Veículo vinculado</th>--}}
                                        <th>Última conexão</th>
                                        <th>Bateria</th>

                                        <th class="text-right">OPÇÕES</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    @foreach($operators as $operator)
                                        <tr>
                                            <td>{{$operator->id}}</td>
                                            <td>
                                                <a class="" href="{{ route('operators.show', $operator->uuid) }}">
                                                    {!! ($operator->status != 1)? "<strike>" : "" !!}
                                                    {{ strtoupper($operator->name)}}{!! ($operator->status != 1)? "<strike>" : "" !!}
                                                    @if($operator->mobile_number) ({{$operator->mobile_number}}) @endif
                                                </a>
                                            </td>
                                            <td>{{$operator->device_version}}</td>
                                            <td>{{$operator->email}}</td>
                                            <td><span class="badge bg-blue">{{ $operator->roles->implode("name", " | ") }}</span> </td>

                                            <td>{{$operator->teams[0]->name}} </td>
                                            {{--                                    <td>{{$operator->teams[0]->users()->wherePivot('is_supervisor',1)->first()->name}}</td>--}}
                                            {{--                                    <td>@if($operator->device){{$operator->device}} (Versão: {{$operator->device_version}})@endif</td>--}}
                                            {{--                                    <td>{{$operator->regions->implode('name',', ')}}</td>--}}

                                            <td>{{$operator->status()}}</td>
                                            {{--                                    <td>{{ date('d/m/Y H:i:s', strtotime($operator->created_at)) }}</td>--}}
                                            {{--<td>--}}
                                            {{--@if($operator->vehicle)--}}
                                            {{--<strong>{{$operator->vehicle->types()}}:</strong> {{$operator->vehicle->brand}} {{$operator->vehicle->model}} <br/>--}}
                                            {{--<strong>Placa: </strong>{{$operator->vehicle->placa}}--}}
                                            {{--@endif--}}
                                            {{--</td>--}}
                                            <td class="{{tempo_color($operator->last_connection)}}">{{ $operator->last_connection() }}</td>
                                            <td class="{{bateria_color($operator->battery)}}">{{ $operator->battery }}</td>

                                            <td class="text-right">
                                                @shield('operator.show')
                                                <a href="{{ route('operators.show', $operator->uuid) }}" class="btn btn-icon btn-sm btn-primary" data-toggle="tooltip" data-placement="left" title="Exibir"><i class="bx bx-book-open"></i></a>
                                                @endshield
                                                @shield('operator.edit')
                                                <a href="{{ route('operators.edit', $operator->uuid) }}" class="btn btn-icon btn-sm btn-warning" data-toggle="tooltip" data-placement="left" title="Editar"><i class="bx bx-pencil"></i></a>
                                                @endshield
                                                @shield('operator.destroy')
                                                <form action="{{ route('operators.destroy', $operator->uuid) }}"
                                                      method="POST" style="display: inline;"
                                                      onsubmit="if(confirm('Deseja deletar esse item?')) { return true } else {return false };">
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                    <button type="submit" class="btn btn-icon btn-sm btn-danger" data-toggle="tooltip" data-placement="left" title="Deletar"><i class="bx bx-trash"></i></button>
                                                </form>
                                                @endshield
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            {!! $operators->render() !!}
                        @else
                            <h3 class="text-center alert alert-info">Vazio!</h3>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('scripts')
    <!-- Select2 -->
    <script src="/bower_components/AdminLTE/plugins/select2/select2.full.min.js"></script>
    <script nonce="{{ csp_nonce() }}">
        $(function () {
            //Initialize Select2 Elements
            $(".select2").select2({
                allowClear: true,
                width: "100%"
            });
        });

        $(document).on('click','#btnGerar', function (e) {
            e.preventDefault();

        $.ajaxSetup({
                headers:{'X-CSRF-Token': '{{ csrf_token() }}'}
            });

                e.preventDefault();
                $('#form_export').attr('action', "{{ route('export.operator') }}").submit();
        });
        


    </script>
@endsection
