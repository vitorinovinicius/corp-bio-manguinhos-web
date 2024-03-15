<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/pickers/daterange/daterangepicker.css')}}">
<!-- Select2 -->
<link rel="stylesheet" href="/bower_components/AdminLTE/plugins/select2/select2.min.css">

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
            <div class="card-content collapse {{(app('router')->is("export.index") || app('request')->exists('occurrence_type_id') ) ? "show" : "" }}">
                <div class="card-body">
                    <form class="form form-vertical form_export" method="GET">
                        <div class="form-body">
                            <div class="row">
                                @if(Route::is("admin.occurrences.unassigned") != Route::current())
                                <div class="col-4">
                                    <div class="form-group">
                                        <label for="occurrence_type_id">Técnico</label>
                                        <select class="form-control select2" id="operator_id" name="operator_id" data-placeholder="Técnico">
                                            <option></option>
                                            <option value="x" {{((app('request')->input('operator_id')=="x") ? "selected":"")}}>Sem técnico associado</option>
                                            @forelse($operators as $operator)
                                                <option value="{{$operator->id}}" {{((app('request')->input('operator_id')==$operator->id) ? "selected":"")}}>{{$operator->id}} - {{$operator->name}} @if($operator->contractor) - {{$operator->contractor->name}} @endif</option>
                                            @empty
                                            @endforelse
                                        </select>
                                    </div>
                                </div>
                                @endif
                                <div class="col-4">
                                    <div class="form-group">
                                        <label for="occurrence_type_id">Data</label>
                                        <input type="text" class="input-small daterange form-control noBackgroung" size="25" id="date_record" name="date_record" value="{{ app('request')->input('date_record') }}" readonly>
                                    </div>
                                </div>
                                @is(['superuser','regiao'])
                                <div class="col-4">
                                    <div class="form-group">
                                        <label for="occurrence_type_id">Empreiteira</label>
                                        <select class="form-control select2" id="contractor_id" name="contractor_id" data-placeholder="Empreiteira">
                                            <option></option>
                                            @forelse($contractors as $contractor)
                                                <option value="{{$contractor->id}}" {{((app('request')->input('contractor_id')==$contractor->id) ? "selected":"")}}>{{$contractor->name}}</option>
                                            @empty
                                            @endforelse
                                        </select>
                                    </div>
                                </div>
                                @endis
                            </div>

                            <div class="row">
                                <div class="col-12 d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary " id="btn-external-filter"><i class="bx bx-search"></i> Buscar</button>
                                    <a href="/{{Route::getCurrentRoute()->uri()}}" class="btn btn-default"><i class="bx bx-eraser"></i> Limpar</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@section('scripts2')
    <script src="{{asset('vendors/js/pickers/daterange/moment.min.js')}}"></script>
    <script src="{{asset('vendors/js/pickers/daterange/daterangepicker.js')}}"></script>
    <!-- Select2 -->
    <script src="/bower_components/AdminLTE/plugins/select2/select2.full.min.js"></script>
    <script nonce="{{ csp_nonce() }}">
        $(function () {
            //Initialize Select2 Elements
            $(".select2").select2({
                allowClear: true,
                width: "100%"
            });


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
