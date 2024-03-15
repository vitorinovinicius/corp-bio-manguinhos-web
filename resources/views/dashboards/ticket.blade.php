@extends('layouts.frest_template')
@section('css')
    <!-- DataTables -->
    <link rel="stylesheet" href="/js/datatables/dataTables.bootstrap.css">
    @if(env('TIPO_MAPA') == 'LEAFLETJS')
       <!-- Leaflet Map -->
    <link rel="stylesheet" href="/leaflet/dist/leaflet.css">
    <!-- Leaflet Routing Machine -->
    <link rel="stylesheet" href="/leaflet-routing-machine/dist/leaflet-routing-machine.css">
    <!-- Leaflet Fullscreen plugin -->
    <link rel="stylesheet" href="/leaflet-fullscreen-1.6.0/Control.FullScreen.css">
    <!-- Leaflet Geocoding plugin -->
    <link rel="stylesheet" href="https://unpkg.com/esri-leaflet-geocoder@2.3.3/dist/esri-leaflet-geocoder.css"
          integrity="sha512-IM3Hs+feyi40yZhDH6kV8vQMg4Fh20s9OzInIIAc4nx7aMYMfo+IenRUekoYsHZqGkREUgx0VvlEsgm7nCDW9g=="
          crossorigin="">
    @endif
@endsection

@section('content-header')
    <div class="content-header-left col-12 mb-2 mt-1">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h5 class="content-header-title float-left pr-1 mb-0">Monitoramento</h5>
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb p-0 mb-0">
                        <li class="breadcrumb-item"><i class="bx bx-home-alt"></i> Home</li>
                        <li class="breadcrumb-item">Dashboard</li>
                        <li class="breadcrumb-item active">Monitoramento</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    @include('error')
    @include('helpers/filter_occurrences_dashboard')    
    @include('dashboards.contadores_tikets')


    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Tikets</h4>
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
                    <div class="table-responsive">
                        <table id="table1" class="table table-sm table-striped table-hover table-condensed">
                            <thead>
                            <tr>
                                <th class="text-left">ID</th>
                                <th class="text-left">Descrição</th>
                                <th class="text-left">Status</th>
                                <th class="text-left">Justificativa</th>
                                <th class="text-left">Criado em</th>
                                <th class="text-left">OS</th>
                            </tr>
                            </thead>

                            <tbody>
                            </tbody>
                        </table>
                    </div>
            </div>
        </div>
    </div>

@endsection
@section('scripts')

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
            var table = $('#table1').DataTable({
                "paging": false,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": true,
                "ajax": '{!! route('admin.dashboard_tickets.list',request()->all()) !!}',
                "dataSrc": "",
                "order": [[1, "desc"], [2, "desc"],[3, "desc"]],
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Portuguese.json"
                },
                "columns": [
                    {data: "id"},
                    {data: "description"},
                    {data: "status"},
                    {data: "justification"},
                    {data: "created_at"},
                    {data: "OS"},
                ],
                
            });

        });
    </script>
@endsection
