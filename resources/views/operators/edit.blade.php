@extends('layouts.frest_template')
@section('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.0/css/bootstrap-datepicker.css"
          rel="stylesheet">
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

        .cpf_invalido {
            color: #dd4b39;
            font-size: 12px;
        }
    </style>
@endsection

@section('content-header')
    <div class="content-header-left col-12 mb-2 mt-1">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h5 class="content-header-title float-left pr-1 mb-0">Técnicos / Editar #{{$operator->id}}</h5>
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb p-0 mb-0">
                        <li class="breadcrumb-item"><i class="bx bx-home-alt"></i> Home</li>
                        <li class="breadcrumb-item">Técnicos</li>
                        <li class="breadcrumb-item active">Editar</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    @include('error')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="box-title">Editar Operador</h3>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <form class="form form-vertical" action="{{ route('operators.update', $operator->uuid) }}" method="POST" id="form" enctype="multipart/form-data">
                            <input type="hidden" name="_method" value="PUT">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="name">Nome*</label>
                                            <input type="text" autocomplete="off" class="form-control" name="name" value="{{$operator->name}}" placeholder="Nome" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="name">E-mail*</label>
                                            <input type="email" autocomplete="off" class="form-control" name="email" value="{{$operator->email}}" placeholder="E-mail" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="name">Código do Celular</label>
                                            <input type="text" autocomplete="off" class="form-control" name="mobile_number" value="{{$operator->mobile_number}}" placeholder="Número para controle interno">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="name">CPF</label>
                                            <div class="cpf_invalido"><i>CPF inválido</i></div>
                                            <input type="text" autocomplete="off" class="form-control cpf_cnpj" name="cpf" value="{{$operator->cpf}}" placeholder="CPF" required>
                                        </div>
                                    </div>
                                </div>
                                {{-- <div class="row">
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
                                </div> --}}
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="name">CNH</label>
                                            <input type="text" class="form-control" name="cnh" value="{{$operator->cnh}}" placeholder="CNH">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="name">Tipo CNH</label>
                                            <input type="text" class="form-control" name="cnh_type" value="{{$operator->cnh_type}}" placeholder="Tipo CNH" autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="name">Validade CNH</label>
                                            <input type="text" class="form-control date" name="cnh_expires" value="{{$operator->cnh_expires()}}" placeholder="Validade CNH" autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="name">Veículo associado</label>
                                            <select class="form-control select2" name="vehicle_id">
                                                @if($operator->vehicle != null)
                                                    <option selected
                                                            value="{{$operator->vehicle->id}}">{{$operator->vehicle->types()}}
                                                        : {{$operator->vehicle->brand}} | {{$operator->vehicle->model}}
                                                        | {{$operator->vehicle->placa}} </option>
                                                @endif

                                                <option value="">Não vinculado</option>
                                                @forelse($vehicles as $vehicle)
                                                    <option value="{{$vehicle->id}}"> {{$vehicle->types()}}: {{$vehicle->brand}}
                                                        | {{$vehicle->model}} | {{$vehicle->placa}} </option>
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
                                                    <option value="{{$workday->id}}" @if($workday->id == $operator->workday_id) selected @endif>{{$workday->name}}</option>
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

                                                    <option value="{{$team->id}}"
                                                            @if($operator->teams->count()) @if($operator->teams[0]->id == $team->id) SELECTED @endif @endif>{{$team->name}}
                                                        -
                                                        Supervisor: {{optional($team->users()->wherePivot('is_supervisor',1)->first())->name}}</option>
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
                                            <input type="text" class="form-control" name="operator_start_point" value="{{$operator->operator_start_point}}" autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="operator_arrival_point">Ponto de Chegada</label>
                                            <input type="text" class="form-control" name="operator_arrival_point" value="{{$operator->operator_arrival_point}}" autocomplete="off">
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
                                                            {{ Form::checkbox('region_id[]', $region->id, in_array($region->id, $selectedRegions),['class' => 'cs_checkbox']) }}
                                                            {{ Form::label('region_id', ucfirst($region->name)) }}<br>
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
                                            <label for="name">Foto do técnico @if($operator->foto) - Já existe para substituir selecione outro @endif</label>
                                            @if($operator->foto)
                                                <div class="col-md-4"><p><img src="{{$operator->foto}}" alt="" class="img-responsive" style="max-width: 250px;"></p>
                                                </div>
                                            @endif
                                            <input type="file" class="form-control" name="foto" >
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="name">Status</label>
                                            <select class="form-control select2" name="status" id="status"
                                                    data-placeholder="Selecione um status" required>
                                                <option></option>
                                                <option value="1" {{($operator->status == 1)? "selected" : ""}}>Habilitado</option>
                                                <option value="2" {{($operator->status != 1)? "selected" : ""}}>Desabilitado
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label>Senha</label>
                                            <p class="">
                                                <a href="{{route('users.change_password',$operator->uuid)}}" class="btn btn-warning">Alterar senha</a>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary">Salvar</button>
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
@section('scripts')
    <script type="text/javascript" src="/bower_components/AdminLTE/plugins/datepicker/bootstrap-datepicker.js"></script>
    <script src="/bower_components/AdminLTE/plugins/select2/select2.full.min.js"></script>
    <script type="text/javascript" src="/js/mask.js"></script>
    <script type="text/javascript" src="/js/cpf_cnpj_extra.js"></script>
    <script type="text/javascript" src="/js/valida_cpf_cnpj.js"></script>
    <script nonce="{{ csp_nonce() }}">
        $(function () {

            $(".select2").select2({
                allowClear: true
            });
        });

        $(document).ready(function () {
            $(".cpf_cnpj").mask("999.999.999-99");
        });

        $('input').keyup(function () {
            this.value = this.value.toLocaleUpperCase();
        });
        $('.cpf_invalido').hide();


        $("#form").submit(function () {
            if ($(".cpf_cnpj").hasClass('invalido')) {
                alert('CPF inválido');
                return false;
            }
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
    </script>
@endsection
