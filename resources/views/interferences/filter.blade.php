<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/pickers/pickadate/pickadate.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/pickers/daterange/daterangepicker.css')}}">
<!-- Select2 -->
<link rel="stylesheet" href="/bower_components/AdminLTE/plugins/select2/select2.min.css">
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
    <div class="card-content collapse {{ app('request')->exists('scheduled_date') == false ? "" : "show"}}">
        <div class="card-body">
            <form class="form form-horizontal" method="get">
                <div class="form-body">
                    <div class="row">
                        @is(['superuser','regiao','financeiro'])
                        @if(isset($contractors))
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="contractor">Empreiteiras</label>
                                    <select id="contractor" class="form-control select2" name="contractor_id" data-placeholder="Selecione o tipo da Ocorrência">
                                        <option></option>
                                        @forelse($contractors as $contractor)
                                            <option value="{{$contractor->id}}" {{(app('request')->input('contractor_id')==$contractor->id?"selected":"")}}>{{$contractor->name}}</option>
                                        @empty
                                        @endforelse
                                    </select>
                                </div>
                            </div>
                        @endif
                        @endis
                        <div class="col-4">
                            <div class="form-group">
                                <label for="agendamento">Período</label>
                                <input id="agendamento" class="form-control daterange" size="25" id="scheduled_date" name="scheduled_date" value="{{ app('request')->input('scheduled_date') }}" readonly>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <br>
                                <button type="submit" class="btn btn-primary " id="btn-external-filter">Aplicar</button>
                                <a href="/{{Route::getCurrentRoute()->uri()}}" class="btn btn-default">Limpar</a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@section('scripts2')
    <script src="{{asset('vendors/js/pickers/daterange/moment.min.js')}}"></script>
    <script src="{{asset('vendors/js/pickers/daterange/daterangepicker.js')}}"></script>
    <!-- Select2 -->
    <script src="/bower_components/AdminLTE/plugins/select2/select2.full.min.js"></script>
    <script>
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
