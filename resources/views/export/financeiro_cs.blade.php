@extends('layouts.adminlte')
@section('css')
    <link rel="stylesheet" type="text/css" href="/bower_components/AdminLTE/plugins/daterangepicker/daterangepicker.css"/>
    <!-- Select2 -->
    <link rel="stylesheet" href="/bower_components/AdminLTE/plugins/select2/select2.min.css">
@endsection
@section('header')
    <div class="page-header clearfix">
        <h3>
            Exportação de relatório de cobrança Central System
        </h3>
        <small>Exporta para Excel as Ocorrências Realizadas pela empreiteira selecionada no período escolhido. <p>Não é permitido exportar mais que 1 mês.</p></small>
    </div>
@endsection

@section('content')
    @include('messages')
    @include('error')
    <link rel="stylesheet" type="text/css" href="/bower_components/AdminLTE/plugins/daterangepicker/daterangepicker.css"/>
    <!-- Select2 -->
    <link rel="stylesheet" href="/bower_components/AdminLTE/plugins/select2/select2.min.css">
    <div class="box box-default clearfix">
        <div class="box-header with-border">
            <h3 class="box-title">Escolha o período e empreiteira</h3>

        </div>
        <div class="box-body">

            <div class="row">
                <form method="get" class="form_export">
                    <input type="hidden" name="status" value="2">

                    <div class="col-md-12 clearfix">
                        <div class="form-group col-md-3">
                            <div>Agendado</div>
                            <input type="text" class="input-small daterange form-control noBackgroung" size="25" id="scheduled_date" name="scheduled_date" value="{{ app('request')->input('scheduled_date') }}" readonly required>
                        </div>
                        @is(['superuser','regiao','financeiro_cs'])
                        <div class="form-group col-md-4">
                            Empreiteira
                            <select class="form-control select2" id="contractor_id" name="contractor_id" data-placeholder="Empreiteira" required>
                                <option></option>
                                @forelse($contractors as $contractor)
                                    <option value="{{$contractor->id}}" {{((app('request')->input('contractor_id')==$contractor->id) ? "selected":"")}}>{{$contractor->name}}</option>
                                @empty
                                @endforelse
                            </select>
                        </div>
                        @endis
                    </div>
                    <div class="col-md-12 clearfix">
                        <div class="form-group col-md-4">
                            <br>
                                <a href="#" class="btn btn-success btnGerar"><i class="bx bx-download"></i> Exportar</a>
                            <a href="/{{Route::getCurrentRoute()->uri()}}" class="btn btn-default"><i class="bx bx-eraser"></i> Limpar</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@section('scripts2')
    <script type="text/javascript" src="/bower_components/AdminLTE/plugins/daterangepicker/moment.min.js"></script>
    <script type="text/javascript" src="/bower_components/AdminLTE/plugins/daterangepicker/daterangepicker.js"></script>
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


@endsection
@section('scripts')
    <script>
        $(function () {
            $(document).on('click','.btnGerar', function (e) {

            $.ajaxSetup({
                    headers:{'X-CSRF-Token': '{{ csrf_token() }}'}
                });

                    e.preventDefault();
                    $('.form_export').attr('action', "{{ route('export.export') }}").submit();
            });
        });


    </script>
@endsection
