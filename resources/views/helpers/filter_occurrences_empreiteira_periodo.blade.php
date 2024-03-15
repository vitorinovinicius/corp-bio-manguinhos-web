
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/pickers/daterange/daterangepicker.css')}}">
<link rel="stylesheet" href="/bower_components/AdminLTE/plugins/select2/select2.min.css">
<div class="box box-default clearfix {{ app('request')->exists('contractor_id') == false ? "collapsed-box" : ""}}">
    <div class="box-header with-border">
        <h3 class="box-title">Filtro</h3>
        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="bx bx-plus"></i></button>
        </div>
    </div>
    <div class="box-body">
        <div class="row">
            <form method="get">
                <div class="col-md-12">
                    @is(['superuser','regiao'])
                        <div class="form-group col-md-4">
                            <div>Empreiteiras</div>
                            <select class="form-control select2" name="contractor_id" data-placeholder="Selecione a empreiteira">
                                <option></option>
                                @forelse($contractors as $contractor)
                                    <option value="{{$contractor->id}}" {{(app('request')->input('contractor_id')==$contractor->id?"selected":"")}}>{{$contractor->name}}</option>
                                @empty
                                @endforelse
                            </select>
                        </div>
                    @endis
                    <div class="form-group col-md-2">
                        <div>Agendado</div>
                        <input type="text" class="input-small daterange" size="25" id="scheduled_date" name="scheduled_date" value="{{ app('request')->input('scheduled_date') }}" readonly>
                    </div>
                    <div class="form-group col-md-2">
                        <br>
                        <button type="submit" class="btn btn-primary " id="btn-external-filter">Aplicar</button>
                        <a href="/{{Route::getCurrentRoute()->uri()}}" class="btn btn-default">Limpar</a>
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
