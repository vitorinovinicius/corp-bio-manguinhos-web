@extends('layouts.frest_template')
@section('css')
    <!-- DataTables -->
    <link rel="stylesheet" href="/js/datatables/dataTables.bootstrap.css">
@endsection

@section('content-header')
    <div class="content-header-left col-10 mb-2 mt-1">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h5 class="content-header-title float-left pr-1 mb-0">Relatórios</h5>
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb p-0 mb-0">
                        <li class="breadcrumb-item"><i class="bx bx-home-alt"></i> Home</li>
                        <li class="breadcrumb-item active">Relatórios</li>
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
                    <h3 class="box-title">Relatórios</h3>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        @if($relatorios->count())
                            <div class="table-responsive">
                                <table class="table table-condensed table-striped table-sm table-hover" data-order='[[ 0, "desc" ]]' data-page-length='25'>
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Nome</th>
                                            <th>Status</th>
                                            <th>Criado Em</th>
                                            <th>Atualizado Em</th>
                                            <th class="text-right">OPÇÕES</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($relatorios as $index => $relatorio)
                                        <tr>
                                            <td>{{ $relatorio->id }}</td>
                                            <td>{{ $relatorio->descricao }}</td>
                                            <td>
                                                <span class="badge {{ $relatorio->badge_status() }}">{{ $relatorio->status() }}</span>
                                            </td>
                                            <td>{{ date('d/m/Y H:m', strtotime($relatorio->created_at)) }}</td>
                                            <td>{{ date('d/m/Y H:m', strtotime($relatorio->updated_at)) }}</td>
                                            <td class="text-right">
                                                @if($relatorio->status == 1)
                                                    <a href="{{ asset($relatorio->url_documento) }}" class="btn btn-icon btn-sm btn-success" data-toggle="tooltip" data-placement="left" title="Baixar arquivo"><i class="bx bx-download"></i></a>
                                                @else
                                                    <button type="button" class="btn btn-icon" data-toggle="tooltip" data-placement="left" title="Arquivo ainda não está pronto"><i class="bx bx-download" disabled></i></a>
                                                @endif
                                                @is(['superuser', 'admin'])
                                                    <form id="deleteForm_{{ $relatorio->uuid }}"
                                                        action="{{ route('relatorio.destroy', $relatorio->uuid) }}"
                                                        method="POST" style="display: inline;">
                                                        <input type="hidden" name="_method" value="DELETE">
                                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                        <button type="button"
                                                                class="btn btn-icon btn-sm btn-danger"
                                                                onclick="deleteForm('{{ $relatorio->uuid }}')"
                                                                data-toggle="tooltip" data-placement="left" title="Deletar">
                                                            <i class="bx bx-trash"></i>
                                                        </button>
                                                    </form>
                                                @endis
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <h3 class="text-center alert alert-info">Nenhum arquivo disponível!</h3>
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
                lengthChange: false,
                paginate: true,
                info: false,
                
                language: {
                    info: "Mostrando de _START_ a _END_ de um total de _TOTAL_ paginas",
                    paginate: {
                        first: "Primeira",
                        previous: "Anterior",
                        next: "Proxima",
                        last: "Ultima",
                        search: 'Filtro:'
                    },
                },
                bFilter: true
            });
        });
    </script>
    @if(session('message'))
        <script>
            Swal.fire({
                position: "center",
                icon: "success",
                title: '{{ session('message') }}',
                showConfirmButton: false,
                timer: 1500
            });
        </script>
    @endif
    <script>
        function deleteForm(uuid) {
            Swal.fire({
                title: 'Deseja deletar esse item?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sim, deletar!',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Form submission if user confirms
                    document.getElementById('deleteForm_' + uuid).submit();
                }
            });
        }
    </script>
@endsection
