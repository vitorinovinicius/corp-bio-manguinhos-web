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
                <h5 class="content-header-title float-left pr-1 mb-0">Tickets</h5>
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb p-0 mb-0">
                        <li class="breadcrumb-item"><i class="bx bx-home-alt"></i> Home</li>
                        <li class="breadcrumb-item active">Tickets</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="col-2 d-flex justify-content-end align-items-center">
        @is(['cliente'])
        <a class="btn btn-success pull-right" href="{{ route('ticket.create') }}"><i class="bx bx-plus"></i> Novo</a>
        @endis
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
                                                @forelse(App\Models\Contractor::all() as $contractor)
                                                    <option value="{{$contractor->id}}" {{(app('request')->input('contractor_id')==$contractor->id?"selected":"")}}>{{$contractor->name}}</option>
                                                @empty
                                                @endforelse
                                            </select>
                                        </div>
                                    </div>
                                    @endis                                    
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label for="occurrence_client_id">Cliente</label>
                                            <select class="form-control select2" name="occurrence_client_id" data-placeholder="Selecione um cliente">
                                                <option></option>
                                                @forelse($occurrenceClients as $occurrenceClient)
                                                    <option value="{{$occurrenceClient->id}}" {{(app('request')->input('occurrence_client_id')==$occurrenceClient->id?"selected":"")}}>{{$occurrenceClient->name}}</option>
                                                @empty</
                                                @endforelse
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-2">
                                        <div class="form-group">
                                            <label for="team_id">Status</label>
                                            <select class="form-control select2" name="status" data-placeholder="Selecione o status">
                                                <option></option>
                                                <option value="1" {{(app('request')->input('status')==1?"selected":"")}}>Em aberto</option>
                                                <option value="2" {{(app('request')->input('status')==2?"selected":"")}}>Cancelado</option>
                                                <option value="3" {{(app('request')->input('status')==2?"selected":"")}}>Gerou OS</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                               
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
                    <h3 class="box-title">Tickets ({{$tickets->count()}})</h3>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        @if($tickets->count())
                            <div class="table-responsive">
                                <table class="table table-condensed table-striped table-sm table-hover" data-page-length='50'>
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Criado por</th>
                                        <th>Cliente</th>
                                        <th>Tipo</th>
                                        <th>Status</th>
                                        @is(['regiao','superuser'])
                                            <th>Empreiteiras</th>
                                        @endis
                                        <th class="text-right">OPÇÕES</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    @foreach($tickets as $ticket)
                                        <tr>
                                            <td>{{$ticket->id}}</td>
                                            <td>{{ optional($ticket->user)->name}}</td>
                                            <td>{{ optional($ticket->occurrence_client)->name}}</td>
                                            <td>{{ $ticket->description_type_ticket}}</td>
                                            <td>{{ $ticket->getStatus($ticket->status)}}</td>
                                            <td>{{ optional($ticket->contractor)->name}}</td>                                           

                                            <td class="text-right">
                                                @shield('ticket.show')
                                                <a href="{{ route('ticket.show', $ticket->uuid) }}" class="btn btn-icon btn-sm btn-primary" data-toggle="tooltip" data-placement="left" title="Exibir"><i class="bx bx-book-open"></i></a>
                                                @endshield
                                                {{-- @shield('ticket.edit')
                                                <a href="{{ route('ticket.edit', $ticket->uuid) }}" class="btn btn-icon btn-sm btn-warning" data-toggle="tooltip" data-placement="left" title="Editar"><i class="bx bx-pencil"></i></a>
                                                @endshield --}}
                                                {{-- @shield('ticket.destroy')
                                                <form action="{{ route('ticket.destroy', $ticket->uuid) }}"
                                                      method="POST" style="display: inline;"
                                                      onsubmit="if(confirm('Deseja deletar esse item?')) { return true } else {return false };">
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                    <button type="submit" class="btn btn-icon btn-sm btn-danger" data-toggle="tooltip" data-placement="left" title="Deletar"><i class="bx bx-trash"></i></button>
                                                </form>
                                                @endshield --}}
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            {!! $tickets->render() !!}
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
