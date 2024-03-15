@extends('layouts.frest_template')
@section('css')
    <link rel="stylesheet" href="{{asset('/bower_components/AdminLTE/plugins/select2/select2.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/css/pickers/daterange/daterangepicker.css')}}">
@endsection

@section('content-header')
    <div class="content-header-left col-10 mb-2 mt-1">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h5 class="content-header-title float-left pr-1 mb-0">Plano de manutenção</h5>
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb p-0 mb-0">
                        <li class="breadcrumb-item"><i class="bx bx-home-alt"></i> Home</li>
                        <li class="breadcrumb-item active">Plano de manutenção</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="col-2 d-flex justify-content-end align-items-center">
        @shield('plan_occurrences.create')
            <a href="{{route('plan_occurrences.create')}}" class="btn btn-primary">Novo</a>
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
                <div class="card-content collapse {{app('request')->exists('name') == false ? "" : "show" }}">
                    <div class="card-body">
                        <form class="form form-vertical form_export" method="GET">
                            <div class="form-body">
                                <div class="row">
                                    @is('superuser')
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label>Empreiteira</label>
                                            <select class="form-control select2" name="contractor_id" data-placeholder="Selecione uma empreiteira">
                                                <option></option>
                                                @forelse(\App\Models\Contractor::all() as $contractor)
                                                    <option value="{{$contractor->id}}">{{$contractor->name}}</option>
                                                @empty
                                                @endforelse
                                            </select>
                                        </div>
                                    </div>
                                    @endis
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label for="name">Tipo de OS</label>
                                            <select class="form-control select2" name="occurrence_type_id" id="occurrence_type_id" data-placeholder="Técnico">
                                                <option></option>
                                                @if($occurrenceTypes)
                                                    @foreach ($occurrenceTypes as $type)
                                                        <option value="{{$type->id}}" {{(app('request')->input('occurrence_type_id')==$type->id?"selected":"")}}>{{$type->name}}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label>Técnico</label>
                                            <select class="form-control select2" name="operator_id" id="operator_id" data-placeholder="Técnico">
                                                <option></option>
                                                @if($operators)
                                                    @foreach ($operators as $operator)
                                                        <option value="{{$operator->id}}" {{(app('request')->input('operator_id')==$operator->id?"selected":"")}}>{{$operator->name}}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label>Status</label>
                                            <select class="form-control select2" name="status" id="" data-placeholder="Selecione um status">
                                                <option></option>
                                                <option value="1" {{(app('request')->input('status')==1?"selected":"")}}>Ativo</option>
                                                <option value="2" {{(app('request')->input('status')==2?"selected":"")}}>Inativo</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label for="name">Periodicidade</label>
                                            <input type="text" class="form-control" id="schedule" name="schedule" value="{{ app('request')->input('schedule') }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label>Data Inicio</label>
                                            <input class="form-control" type="date" name="date_begin" placeholder="document_date" value="{{ app('request')->input('date_begin') }}">
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label>Data Término</label>
                                            <input class="form-control" type="date" name="date_finish" placeholder="document_date" value="{{ app('request')->input('date_finish') }}">
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <br>
                                        <div class="form-group form-check">
                                            <input type="checkbox" class="form-check-input" id="weekend" name="weekend">
                                            <label class="form-check-label">Final de semana</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12 d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary" id="btn-external-filter">Aplicar</button>
                                        <a href="/{{Route::getCurrentRoute()->uri()}}" class="btn btn-link"><i class="bx bx-eraser"></i> Limpar</a>
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
                    <div class="d-flex justify-content-between">
                        <h3 class="box-title">Plano de manutenção</h3>
                    </div>

                </div>
                <div class="card-content">
                    <div class="card-body">
                        @if($planOccurrences->count())
                            <div>
                                <table class="table table-condensed table-striped table-sm">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        @is('superuser')
                                        <th>Empreiteira</th>
                                        @endis
                                        <th>Tipo de OS</th>
                                        <th>Cliente</th>
                                        <th>Técnico</th>
                                        <th>Início</th>
                                        <th>Fim</th>
                                        <th>Final de semana</th>
                                        <th>Status</th>
                                        <th class="text-right">OPÇÕES</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    @foreach($planOccurrences as $plan)
                                        <tr>
                                            <td>{{$plan->id}}</td>
                                            @is('superuser')
                                            <td>{{$plan->contractor->name}}</td>
                                            @endis
                                            <td>{{optional($plan->occurrenceType)->name}}</td>
                                            <td>{{optional($plan->occurrenceClient)->name}}</td>
                                            <td>{{optional($plan->operator)->name}}</td>
                                            <td>{{$plan->date_begin()}}</td>
                                            <td>{{$plan->date_finish()}}</td>
                                            <td>@if($plan->weekend == 1) SIM @else NÃO @endif</td>
                                            <td>@if($plan->status == 1) Ativo @else Inativo @endif</td>

                                            <td class="text-right">
                                                <div class="d-flex justify-content-end">
                                                    @shield('plan_occurrences.show')
                                                    <a href="{{ route('plan_occurrences.show', $plan->uuid) }}" class="btn btn-icon btn-sm btn-primary mr-1" data-toggle="tooltip" title="Exibir"><i class="bx bx-book-open"></i></a>
                                                    @endshield

                                                    @shield('plan_occurrences.edit')
                                                    <a href="{{ route('plan_occurrences.edit', $plan->uuid) }}" class="btn btn-icon btn-sm btn-warning mr-1" data-toggle="tooltip" title="Editar"><i class="bx bx-pencil"></i></a>
                                                    @endshield
                                                    @shield('plan_occurrences.destroy')
                                                    <form action="{{ route('plan_occurrences.destroy', $plan->uuid) }}"
                                                          method="POST" style="display: inline;"
                                                          onsubmit="if(confirm('Deseja deletar esse item?')) { return true } else {return false };">
                                                        <input type="hidden" name="_method" value="DELETE">
                                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                        <button type="submit" class="btn btn-icon btn-sm btn-danger" data-toggle="tooltip" title="Deletar">
                                                            <i class="bx bx-trash"></i></button>
                                                    </form>
                                                    @endshield
                                                </div>
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
    <!-- Select2 -->
    <script src="{{asset('/bower_components/AdminLTE/plugins/select2/select2.full.min.js')}}"></script>
    <script src="{{asset('vendors/js/pickers/daterange/moment.min.js')}}"></script>
    <script src="{{asset('vendors/js/pickers/daterange/daterangepicker.js')}}"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script nonce="{{ csp_nonce() }}">
        $(function () {
            //Initialize Select2 Elements
            $(".select2").select2({
                allowClear: true,
                width: "100%"
            });
        });

        $(function () {
            $('.daterange').daterangepicker({
                autoApply: false,
                autoUpdateInput: false,
//                maxDate: moment(),
                locale: {
                    format: 'DD/MM/YYYY',
                    cancelLabel: 'Limpar',
                    applyLabel: "Ok",
                    fromLabel: "De",
                    toLabel: "Até",
                    daysOfWeek: [
                        "D",
                        "S",
                        "T",
                        "Q",
                        "Q",
                        "S",
                        "S"
                    ],
                    monthNames: [
                        "Janeiro",
                        "Fevereiro",
                        "Março",
                        "Abril",
                        "Maio",
                        "Junho",
                        "Julho",
                        "Agosto",
                        "Setembro",
                        "Outubro",
                        "Novembro",
                        "Dezembro"
                    ],
                },
            });

            $('.daterange').on('apply.daterangepicker', function (ev, picker) {
                $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
            });
            $('.daterange').on('cancel.daterangepicker', function (ev, picker) {
                $(this).val('');
            });
        });
    </script>
@endsection
