<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/pickers/daterange/daterangepicker.css')}}">
<!-- Select2 -->
<link rel="stylesheet" href="/bower_components/AdminLTE/plugins/select2/select2.min.css">

<div class="row">
    <div class="col-md-12">
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
            <div
                class="card-content collapse {{(app('request')->exists('scheduled_date') ) ? "show" : "" }}">
                <div class="card-body">
                    <form class="form form-vertical form_export" method="GET">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="form-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="occurrence_type_id">Ordem de Serviço</label>
                                        <select class="form-control select2" name="occurrence_type_id"
                                                data-placeholder="Selecione o tipo da Ocorrência">
                                            <option></option>
                                            @foreach($occurrence_types as $ot)
                                                <option
                                                    value="{{$ot->id}}" {{(app('request')->input('occurrence_type_id')==$ot->id?"selected":"")}}>{{$ot->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="scheduled_date">Data do agendamento</label>
                                        <input type="text" class="input-small daterange form-control noBackgroung"
                                               size="25" id="scheduled_date" name="scheduled_date"
                                               value="{{ app('request')->input('scheduled_date') }}" readonly>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="date_finish">Data de realização</label>
                                        <input type="text" class="input-small daterange form-control noBackgroung"
                                               size="25" id="date_finish" name="date_finish"
                                               value="{{ app('request')->input('date_finish') }}" readonly>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="id_local">ID</label>
                                        <input class="form-control" type="text" name="id_local" id="id_local"
                                               placeholder="ID Bio-Manguinhos"
                                               value="{{ app('request')->input('id_local') }}">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="status">Status</label>
                                        <select class="form-control select2" name="status" data-placeholder="Status">
                                            <option></option>
                                            <option value="1" {{(app('request')->input('status')==1?"selected":"")}}>Aberta</option>
                                            <option value="2" {{(app('request')->input('status')==2?"selected":"")}}>Realizada</option>
                                            <option value="3" {{(app('request')->input('status')==3?"selected":"")}}>Não Realizada</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="shift">Turno</label>
                                        <select class="form-control select2" name="shift" data-placeholder="Turno">
                                            <option></option>
                                            <option value="1" {{(app('request')->input('shift')==1?"selected":"")}}>Manhã</option>
                                            <option value="2" {{(app('request')->input('shift')==2?"selected":"")}}>Tarde</option>
                                            <option value="3" {{(app('request')->input('shift')==3?"selected":"")}}>Noite</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="siebel_ok">SAP Comunicado?</label>
                                        <select class="form-control select2" id="siebel_ok" name="siebel_ok"
                                                data-placeholder="SAP Comunicado?">
                                            <option></option>
                                            <option
                                                value="1" {{(app('request')->input('siebel_ok')== 1 ?"selected":"")}}>
                                                Sim
                                            </option>
                                            <option
                                                value="0" {{(app('request')->input('siebel_ok')== "0" ?"selected":"")}}>
                                                Não
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="priority">Prioridade</label>
                                        <select class="form-control select2" name="priority"
                                                data-placeholder="Prioridade">
                                            <option></option>
                                            @forelse(priority_list_array() as $key=>$value)
                                                <option
                                                    value="{{$key}}" {{(app('request')->input('priority')==$key?"selected":"")}}>{{$value}}</option>
                                            @empty
                                            @endforelse
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="organizacao">Organização</label>
                                        <select class="form-control select2" name="organizacao"
                                                data-placeholder="Organização">
                                            <option></option>
                                            <option
                                                value="1" {{(app('request')->input('organizacao')== 1 ?"selected":"")}}>
                                                CEG
                                            </option>
                                            <option
                                                value="2" {{(app('request')->input('organizacao')== 2 ?"selected":"")}}>
                                                CEG RIO
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="numero_os">Número da OS</label>
                                        <input class="form-control" type="text" name="numero_os" id="numero_os"
                                               placeholder="2-000000001 2-000000002 2-000000003"
                                               value="{{ app('request')->input('numero_os') }}">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="client_number">Número do Cliente</label>
                                        <input class="form-control" type="text" name="client_number" id="client_number"
                                               placeholder="123456, 456456, 789789"
                                               value="{{ app('request')->input('client_number') }}">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="city">Municipio</label>
                                        <select class="select2" id="city" name="city" data-placeholder="Municipio">
                                            <option></option>
                                            @forelse($occurrence_clients as $key=>$value)
                                                <option
                                                    value="{{$value->city}}" {{((app('request')->input('city')==$value->city) ? "selected":"")}}>{{$value->city}}</option>
                                            @empty
                                            @endforelse
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="district">Bairro</label>
                                        <input class="form-control" type="text" name="district" id="district"
                                               placeholder="Bairro" value="{{ app('request')->input('district') }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="address">Endereço</label>
                                        <input class="form-control" type="text" name="address" id="address"
                                               placeholder="Endereço" value="{{ app('request')->input('address') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                @if(Route::is("admin.occurrences.unassigned") != Route::current())
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="operator_id">Técnico</label>
                                            <select class="form-control select2" id="operator_id" name="operator_id"
                                                    data-placeholder="Técnico">
                                                <option></option>
                                                <option
                                                    value="x" {{((app('request')->input('operator_id')=="x") ? "selected":"")}}>
                                                    Sem técnico associado
                                                </option>
                                                @forelse($operators as $operator)
                                                    <option
                                                        value="{{$operator->id}}" {{((app('request')->input('operator_id')==$operator->id) ? "selected":"")}}>{{$operator->id}}
                                                        - {{$operator->name}} @if($operator->contractor)
                                                            - {{$operator->contractor->name}} @endif</option>
                                                @empty
                                                @endforelse
                                            </select>
                                        </div>
                                    </div>
                                    @if(Request::route()->getName() == "admin.occurrences.closed_unsolved")
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="motivo_id">Motivo Não Realizada</label>
                                                <select class="form-control select2" id="motivo_id" name="motivo_id"
                                                        data-placeholder="Motivo Não Realizada">
                                                    <option></option>
                                                    @forelse($motivos as $motivo)
                                                        <option
                                                            value="{{$motivo->id}}" {{((app('request')->input('motivo_id')==$motivo->id) ? "selected":"")}}>{{$motivo->id}}
                                                            - {{$motivo->name}}</option>
                                                    @empty
                                                    @endforelse
                                                </select>
                                            </div>
                                        </div>
                                    @endif
                                @endif
                                @is(['superuser','regiao','financeiro','financeiro_cs'])
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="contractor_id">Empreiteira</label>
                                        <select class="form-control select2" id="contractor_id" name="contractor_id"
                                                data-placeholder="Empreiteira">
                                            <option></option>
                                            @forelse($contractors as $contractor)
                                                <option
                                                    value="{{$contractor->id}}" {{((app('request')->input('contractor_id')==$contractor->id) ? "selected":"")}}>{{$contractor->name}}</option>
                                            @empty
                                            @endforelse
                                        </select>
                                    </div>
                                </div>
                                @endis
                            </div>
                            <div class="row">
                                <div class="col-md-12 d-flex justify-content-end">
                                    @if(app('router')->is("export.index"))
                                        <a href="#" class="btn btn-success btnGerar"><i class="bx bx-download"></i>
                                            Exportar</a>
                                    @else
                                        <button type="submit" class="btn btn-primary " id="btn-external-filter"><i
                                                class="bx bx-search"></i> Buscar
                                        </button>
                                    @endif
                                <a href="{{route('interferences.relatorio.show',$interference->uuid)}}" class="btn btn-link pull-right"><i
                                            class="bx bx-eraser"></i> Limpar</a>
                                    
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
