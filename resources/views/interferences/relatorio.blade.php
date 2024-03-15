@extends('layouts.frest_template')
@section('css')
    <!-- DataTables -->
    <link rel="stylesheet" href="/js/datatables/dataTables.bootstrap.css">
@endsection

@section('content-header')
    <div class="content-header-left col-10 mb-2 mt-1">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h5 class="content-header-title float-left pr-1 mb-0">Relatório de Interferências</h5>
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb p-0 mb-0">
                        <li class="breadcrumb-item"><i class="bx bx-home-alt"></i> Home</li>
                        <li class="breadcrumb-item">Dashboard</li>
                        <li class="breadcrumb-item active">Relatório de Interferências</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="box-title">Interferências ({{$interferences->count()}})</h3>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        @if($interferences->count())
                            <div class="table-responsive">
                                <table class="table table-striped table-sm table-hover table-condensed">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Descrição</th>
                                        <th>Total de Ocorrências</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    @foreach($interferences as $interference)
                                        <tr>
                                            <td>
                                                <a class="btn-link" href="{{ route('interferences.show', $interference->uuid) }}">{{$interference->description}}</a>
                                            </td>
                                            <td>{{$interference->description}}</td>
                                            <td>{{$interference->occurrences->count()}}</td>

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
                },
            });
        });
    </script>
@endsection
