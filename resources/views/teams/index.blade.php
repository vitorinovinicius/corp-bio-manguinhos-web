@extends('layouts.frest_template')
@section('css')
    <!-- DataTables -->
    <link rel="stylesheet" href="/js/datatables/dataTables.bootstrap.css">
@endsection

@section('content-header')
    <div class="content-header-left col-10 mb-2 mt-1">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h5 class="content-header-title float-left pr-1 mb-0">Equipes</h5>
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb p-0 mb-0">
                        <li class="breadcrumb-item"><i class="bx bx-home-alt"></i> Home</li>
                        <li class="breadcrumb-item active">Equipes</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="col-2 d-flex justify-content-end align-items-center">
        @shield('team.create')
        <a class="btn btn-success pull-right" href="{{ route('teams.create') }}"><i class="bx bx-plus"></i> Novo</a>
        @endshield
    </div>
@endsection

@section('content')
    @include('messages')
    @include('error')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="box-title">Equipes ({{$teams->count()}})</h3>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        @if($teams->count())
                            <div class="table-responsive">
                                <table class="table table-condensed table-striped table-sm table-hover" data-order='[[ 0, "desc" ]]' data-page-length='25'>
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Nome</th>
                                            <th>Supervisor</th>
                                            <th>Criado</th>
                                            <th>Modificado</th>

                                            <th class="text-right">OPÇÕES</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                    @foreach($teams as $team)
                                        <tr>
                                            <td>{{$team->id}}</td>
                                            <td>
                                                <a class="btn-link" href="{{ route('teams.show', $team->uuid) }}">{{$team->name}}</a>
                                            </td>
                                            <td>{{ $team->users()->wherePivot('is_supervisor',1)->get()->implode('name', ' | ') }}</td>
                                            <td>{{ date('d/m/Y H:i:s', strtotime($team->created_at)) }}</td>
                                            <td>{{ date('d/m/Y H:i:s', strtotime($team->updated_at)) }}</td>

                                            <td class="text-right">
                                                @shield('team.show')
                                                <a href="{{ route('teams.show', $team->uuid) }}" class="btn btn-icon btn-sm btn-primary" data-toggle="tooltip" data-placement="left" title="Exibir"><i class="bx bx-book-open"></i></a>
                                                @endshield
                                                {{-- @shield('team.edit')
                                                <a href="{{ route('teams.edit', $team->uuid) }}" class="btn btn-icon btn-sm btn-warning" data-toggle="tooltip" data-placement="left" title="Editar"><i class="bx bx-pencil"></i></a>
                                                @endshield
                                                @shield('team.destroy')
                                                <form action="{{ route('teams.destroy', $team->uuid) }}"
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
    <!-- DataTables -->
    @section('vendor-scripts')
        <script src="{{asset('vendors/js/tables/datatable/datatables.min.js')}}"></script>
        <script src="{{asset('vendors/js/tables/datatable/dataTables.bootstrap4.min.js')}}"></script>
        <script src="{{asset('vendors/js/tables/datatable/dataTables.buttons.min.js')}}"></script>
        <script src="{{asset('vendors/js/tables/datatable/buttons.html5.min.js')}}"></script>
        <script src="{{asset('vendors/js/tables/datatable/buttons.print.min.js')}}"></script>
        <script src="{{asset('vendors/js/tables/datatable/buttons.bootstrap.min.js')}}"></script>
        <script src="{{asset('vendors/js/tables/datatable/pdfmake.min.js')}}"></script>
        <script src="{{asset('vendors/js/tables/datatable/vfs_fonts.js')}}"></script>
    @endsection
    {{-- page scripts --}}
    @section('page-scripts')
        <script src="{{asset('js/scripts/datatables/datatable.js')}}"></script>
    @endsection
    <script nonce="{{ csp_nonce() }}">
        $(function () {
            $('.table').DataTable({
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": true,
                "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Portuguese.json"
            }
            });
        });
    </script>
@endsection
