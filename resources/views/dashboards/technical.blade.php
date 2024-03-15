@extends('layouts.frest_template')
@section('css')
    <!-- DataTables -->
    <link rel="stylesheet" href="/js/datatables/dataTables.bootstrap.css">
@endsection

@section('content-header')
    <div class="content-header-left col-12 mb-2 mt-1">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h5 class="content-header-title float-left pr-1 mb-0">Técnicos</h5>
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb p-0 mb-0">
                        <li class="breadcrumb-item"><i class="bx bx-home-alt"></i> Home</li>
                        <li class="breadcrumb-item">Dashboard</li>
                        <li class="breadcrumb-item active">Técnicos</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    @include('error')

    @include('helpers/filter_occurrences_dashboard')

    @include('dashboards.contadores')

    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Técnicos ({{$operators->count()}})</h4>
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
        <div class="card-content collapse show">
            <div class="card-body">
                @if($operators->count())
                    <div class="table-responsive">
                        <table id="table1" class="table table-sm table-striped table-hover table-condensed">
                            <thead>
                            <tr>
                                <th class="text-center">Nome</th>
                                <th class="text-center">Equipe</th>
                                <th class="text-center">Supervisor</th>
                                <th class="text-center">Total OS</th>
                                <th class="text-center">Realizadas</th>
                                <th class="text-center">Ñ realizadas</th>
                                <th class="text-center">Pendentes</th>
                                <th class="text-center">Eficiência</th>
                                <th class="text-center">Jornada</th>
                                <th class="text-center">Última comunicação</th>
                                <th class="text-center hideColum"></th>
                            </tr>
                            </thead>

                            <tbody class="include_technical">
                            </tbody>
                        </table>
                    </div>
                @endif
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

        //Reload da página - fim

        $(function () {
            var table = $('#table1').DataTable({
                "paging": false,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": true,
                "ajax": '{!! route('admin.dashboard.list',request()->all()) !!}',
                "dataSrc": "",
                "order": [[10, "desc"],[9, "desc"]],
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Portuguese.json"
                },
                "columnDefs": [
                    { targets: 9, orderData: 10 },
                    { targets: 10, visible: false },
                ],
                "columns": [
                    {data: "nome"},
                    {data: "equipe"},
                    {data: "supervisor"},
                    {data: "total_os"},
                    {data: "total_realizadas"},
                    {data: "total_nao_realizadas"},
                    {data: "total_pendentes"},
                    {
                        data: "eficiencia",
                        createdCell: function (td, cellData, rowData) {
                            $(td).addClass(rowData["cor_eficiencia"])
                        }
                    },
                    {
                        data: "media",
                        createdCell: function (td, cellData, rowData) {
                            $(td).addClass(rowData["cor_media"])
                        }
                    },
                    {
                        data: "last_connection",
                        createdCell: function (td, cellData, rowData) {
                            $(td).addClass(rowData["cor_last_connection"])
                        }
                    },
                    {
                        data: "tempo_calc_last_connection",
                    },
                ],
                createdRow: function (row, data) {
                    $(row).addClass(data["cor_eficiencia"])
                }
            });

            setInterval(function () {
                table.ajax.reload();
            }, 1 * 60 * 1000);


        });


    </script>
@endsection
