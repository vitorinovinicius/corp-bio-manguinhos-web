{{--<script src="dataTables.bootstrap4.min.js"></script>--}}
{{--<link rel="stylesheet" type="text/css" href="{{ url('vendors/css/tables/datatable/datatables.min.css') }}">--}}

@if(optional($occurrence->occurrence_client)->occurrences_paginate)
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="box-title">Histórico de ocorrências do cliente</h3>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <hr class=" hidden-pdf">
                        <div class="row hidden-pdf">
                            <div class="col-12 table-responsive">
                                @if(optional($occurrence->occurrence_client)->occurrences_paginate)
                                    <div class="">
                                        <table class="table table-striped data-table table-sm" id="occurrenceClientDatatable" data-order='[[ 0, "desc" ]]' data-page-length='5'>
                                            <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Prioridade</th>
                                                <th>Nome OS</th>
                                                <th>Nº OS</th>
                                                <th>Atribuído para</th>
                                                <th>Agendado</th>
                                                <th>Realizado</th>
                                                <th>Status</th>

                                                <th class="text-right">OPÇÕES</th>
                                            </tr>
                                            </thead>

                                            <tbody>
                                            @foreach(optional($occurrence->occurrence_client)->occurrences_paginate as $occurrence)
                                                <tr>
                                                    <td>{{$occurrence->id}}</td>
                                                    <td>{{priority_name($occurrence->priority)}}</td>
                                                    <td>{{optional($occurrence->occurrence_type)->name}}</td>
                                                    <td>{{$occurrence->numero_os}}</td>
                                                    <td>{{optional($occurrence->operator)->name}}</td>
                                                    <td>{{( empty($occurrence->schedule_date)? "-" : date('d/m/Y', strtotime($occurrence->schedule_date))) }}</td>
                                                    <td>{{( empty($occurrence->check_out)? "-" : date('d/m/Y', strtotime($occurrence->check_out))) }}</td>
                                                    <td>{{($occurrence->getStatus())}}</td>

                                                    <td class="text-right">
                                                        <a href="{{ route('occurrences.show', $occurrence->uuid) }}" class="btn btn-icon btn-sm btn-primary" data-toggle="tooltip" data-placement="left" title="Exibir"><i class="bx bx-book-open"></i></a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <h3 class="text-center">Não há OS associadas a esse cliente</h3>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif

@section('scripts_extra')
    {{--<script src="datatables.min.js"></script>--}}
{{--    <script src="{{ url('vendors/js/tables/datatable/datatables.min.js') }}"></script>--}}
{{--    <script src="{{ url('vendors/js/tables/datatable/datatables.bootstrap.min.js') }}"></script>--}}
{{--    <script src="{{ url('vendors/js/tables/datatable/datatables.buttons.min.js') }}"></script>--}}

@endsection
