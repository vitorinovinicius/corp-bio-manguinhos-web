@extends('layouts.frest_template')
@section('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.0/css/bootstrap-datepicker.css" rel="stylesheet">
    <!-- Select2 -->
    <link rel="stylesheet" href="/bower_components/AdminLTE/plugins/select2/select2.min.css">
    <style nonce="{{ csp_nonce() }}">

         input {
             text-transform: uppercase;
         }
        .invalido {
            border-color: #dd4b39 !important;
            box-shadow: none;
        }
        .cpf_invalido{
            color: #dd4b39;
            font-size: 12px;
        }
    </style>
@endsection

@section('content-header')
    <div class="content-header-left col-12 mb-2 mt-1">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h5 class="content-header-title float-left pr-1 mb-0">Técnicos / Criar</h5>
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb p-0 mb-0">
                        <li class="breadcrumb-item"><i class="bx bx-home-alt"></i> Home</li>
                        <li class="breadcrumb-item">Técnicos</li>
                        <li class="breadcrumb-item active">Criar</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    @include('error')
    @include('messages')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="box-title">Criar Operador</h3>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <form class="form form-vertical" action="{{ route('operators.store') }}" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="name">Nome*</label>
                                            <input type="text" autocomplete="off" class="form-control" name="name" value="{{ old('name') }}" placeholder="Nome" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="name">E-mail*</label>
                                            <input type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="E-mail" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="name">Código do Celular</label>
                                            <input type="text" autocomplete="off" class="form-control" name="mobile_number" value="{{ old('mobile_number') }}" placeholder="">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="name">CPF</label>
                                            <div class="cpf_invalido"><i>CPF inválido</i></div>
                                            <input type="text" autocomplete="off" class="form-control cpf_cnpj" name="cpf" value="{{ old('cpf') }}" placeholder="CPF" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="name">Senha*</label>
                                            <input type="password" class="form-control" name="password" placeholder="Senha" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="name">Confirmar senha*</label>
                                            <input type="password" class="form-control" name="repassword" placeholder="Confirmar senha" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="name">CNH</label>
                                            <input type="text" class="form-control" name="cnh" placeholder="CNH" value="{{ old('cnh') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="name">Tipo CNH</label>
                                            <input type="text" class="form-control" name="cnh_type" placeholder="Tipo CNH" value="{{ old('cnh_type') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="name">Validade CNH</label>
                                            <input type="text" autocomplete="off" class="form-control pull-right date" name="cnh_expires"  value="{{ old('cnh_expires') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="name">Veículo associado</label>
                                            <select class="form-control select2" name="vehicle_id">
                                                <option></option>
                                                @forelse($vehicles as $vehicle)
                                                    <option value="{{$vehicle->id}}"> {{$vehicle->types($vehicle->type)}}: {{$vehicle->brand}} | {{$vehicle->model}} | {{$vehicle->placa}} </option>
                                                @empty
                                                @endforelse
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="name">Jornada de trabalho</label>
                                            <select class="form-control select2" name="workday_id" data-placeholder="Selecione uma equipe">
                                                <option></option>
                                                @forelse($workdays as $workday)
                                                    <option value="{{$workday->id}}">{{$workday->name}}</option>
                                                @empty
                                                @endforelse
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="name">Equipe*</label>
                                            <select class="form-control select2" name="team_id" required data-placeholder="Selecione uma equipe" required>
                                                <option></option>
                                                @forelse($teams as $team)
                                                    <option value="{{$team->id}}">{{$team->name}} - Ssupervisor: {{optional($team->users()->wherePivot('is_supervisor',1)->first())->name}}</option>
                                                @empty
                                                @endforelse
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="operator_start_point">Ponto de Partida</label>
                                            <input type="text" class="form-control" name="operator_start_point" value="{{ old('operator_start_point') }}"  autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="operator_arrival_point">Ponto de Chegada</label>
                                            <input type="text" class="form-control" name="operator_arrival_point" value="{{ old('operator_arrival_point') }}"  autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                                @if(myRegionsContractor()->count() == 1)
                                    <input name="region_id[]" type="hidden" value="{{ myRegionsContractor()->first()->region_id }}">
                                @else
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group" id="regions">
                                                <label for="name">Região*</label>
                                                @foreach($regions as $region)
                                                    <div class="form-check">
                                                        <label class="form-check-label">
                                                            <input class="form-check-input cs_checkbox" name="region_id[]" type="checkbox" value="{{ $region->id }}" required>
                                                            {{ $region->name }}
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="name">Foto do técnico</label>
                                            <input type="file" class="form-control" name="foto" >
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary">Criar</button>
                                        <a class="btn btn-link pull-right"
                                           href="{{ route('operators.index') }}"><i
                                                class="bx bx-arrow-back"></i> Voltar</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts2')
    <!-- Select2 -->
    <script src="/bower_components/AdminLTE/plugins/select2/select2.full.min.js"></script>
    <script type="text/javascript" src="/bower_components/AdminLTE/plugins/datepicker/bootstrap-datepicker.js"></script>
    <script type="text/javascript" src="/js/cpf_cnpj_extra.js"></script>
    <script type="text/javascript" src="/js/valida_cpf_cnpj.js"></script>

    <script nonce="{{ csp_nonce() }}">

        $('input').keyup(function() {
            this.value = this.value.toLocaleUpperCase();
        });

        $('input').keyup(function() {
            this.value = this.value.toLocaleUpperCase();
        });
        $('.cpf_invalido').hide();

        $("#form").submit(function() {
            if($(".cpf_cnpj").hasClass('invalido')){
                alert('CPF inválido');
                return false;
            }
        });


        $(function () {

            //Initialize Select2 Elements
            $(".select2").select2({
                placeholder: "Selecione uma equipe",
                allowClear: true
            });

            $('.date').datepicker({
                format: 'dd/mm/yyyy',
                language: 'pt-BR',
                weekStart: 0,
                todayHighlight: true,
                dayNames: ['Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado'],
                dayNamesMin: ['D', 'S', 'T', 'Q', 'Q', 'S', 'S', 'D'],
                dayNamesShort: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb', 'Dom'],
                monthNames: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
                monthNamesShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
                nextText: 'Próximo',
                prevText: 'Anterior'
            });
        });
    </script>

@endsection
