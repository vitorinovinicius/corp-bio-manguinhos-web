@extends('layouts.frest_template')
@section('css')
    <!-- Select2 -->
    <link rel="stylesheet" href="/bower_components/AdminLTE/plugins/select2/select2.min.css">
@endsection

@section('content-header')
    <div class="content-header-left col-10 mb-2 mt-1">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h5 class="content-header-title float-left pr-1 mb-0">Serviços - Não atribuídos <small>({{$occurrences_all}})</small></h5>
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb p-0 mb-0">
                        <li class="breadcrumb-item"><i class="bx bx-home-alt"></i> Home</li>
                        <li class="breadcrumb-item">Serviços</li>
                        <li class="breadcrumb-item active">Não atribuídos - <small>Lista as Ocorrências de hoje e futuras que foram importadas mas ainda não atribuídas a algum técnico</small></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="col-2 d-flex justify-content-end align-items-center">
        @shield('occurrence.create')
        <a class="btn btn-success pull-right" href="{{ route('occurrences.create') }}"><i class="bx bx-plus"></i> Novo</a>
        @endshield
    </div>
@endsection

@section('content')

    @include('messages')
    @include('error')
    @include('helpers/filter_occurrences')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <meta name="_token" content="{!! csrf_token() !!}" />
                        <div class="row">
                            <div class="col-10">
                                <div class="form-group">
                                    <label>Despachar</label>
                                    <select class="select2 select_operator_id" id="select_operator_id" name="operator_id" data-placeholder="Supervisor - Equipe - Empreiteira">
                                        <option></option>
                                        <option value="auto">Despacho Automático</option>
                                        @forelse($operators as $operator)
                                            <option value="{{$operator->id}}">
                                                {{$operator->id}} - {{$operator->name}}
                                                - {{optional($operator->teams())->first()->name}}
                                                @if($operator->contractor) - {{$operator->contractor->name}} @endif
                                            </option>
                                        @empty
                                        @endforelse
                                    </select>
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="form-group">
                                    <br>
                                    <a class="btn btn-warning" href="#" id="btn-attr-operator" >Atribuir serviços</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="box-title">Serviços - Não atribuídos</h3>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        @if($occurrences->count())
                            <div class="table-responsive">
                                <table class="table table-condensed table-striped  table-sm table-occurrence">
                                    <thead>
                                    <tr>
                                        <th><input type="checkbox" id="check_all" class="cs_checkbox"></th>
                                        <th>ID</th>
                                        <th>Nº OS</th>
                                        <th>Prioridade</th>
                                        <th>OS</th>
                                        @is('superuser')<th>Empreiteira</th>@endis
                                        <th>N. Cliente</th>
                                        <th>Endereço</th>
                                        <th>Bairro</th>
                                        <th>Data de agendamento</th>
                                        <th class="text-right">OPÇÕES</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    @foreach($occurrences as $occurrence)

                                        <tr>
                                            <td><input class="ids_check cs_checkbox" name="ids[]" type="checkbox" value="{{$occurrence->id}}"></td>
                                            <td>{{$occurrence->id}}</td>
                                            <td>{{$occurrence->numero_os}}</td>
                                            <td>{{$occurrence->priority()}}</td>
                                            <td>{{optional($occurrence->occurrence_type)->name}}</td>
                                            @is('superuser')<td>{{optional($occurrence->contractor)->name}}</td>@endis
                                            @if($occurrence->occurrence_client)
                                                <td>
                                                    <a href="{{route("occurrence_clients.show",optional($occurrence->occurrence_client)->uuid)}}">{{optional($occurrence->occurrence_client)->client_number}} - {{optional($occurrence->occurrence_client)->name}}</a>
                                                </td>
                                            @else
                                                <td></td>
                                            @endif
                                            <td>{{optional($occurrence->occurrence_client)->address}}</td>
                                            <td>{{optional($occurrence->occurrence_client)->district}}</td>
                                            <td>{{ $occurrence->dataAgendamentoFormart() }}</td>
                                            <td class="text-right" style="padding: 1.15rem 0 !important;">
                                                @include('occurrences.includes.options')
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            {!! $occurrences->render() !!}
                        @else
                            <h3 class="text-center alert alert-info">Vazio!</h3>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('occurrences.includes.modal_information')

@endsection
@section('scripts')
    <!-- Select2 -->
    <script src="/bower_components/AdminLTE/plugins/select2/select2.full.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.0/js/bootstrap-datepicker.min.js"></script>
    <script nonce="{{ csp_nonce() }}">
        $(function () {
            //Initialize Select2 Elements
            $("#select_operator_id").select2({
                allowClear: true,
                width: "80%"
            });

            $(document).on('click','#check_all',function(){
                if($(this).prop('checked')){
                    $('.ids_check').prop('checked',true);
                }else{
                    $('.ids_check').prop('checked',false);
                }
            });

            $(document).on('click','#btn-attr-operator', function(e){
                e.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                })
                var ids = [];
                $.each($('.table-occurrence tbody :checked'),function(i,v){
                    ids.push($(v).val())
                });
                if(ids.length == 0){
                    alert('Selecione pelo menos uma OS');
                }else{
                    if($('.select_operator_id').val() == ""){
                        alert('Selecione o Técnico');
                    }else{
                        jQuery.ajax({
                            type: 'POST',
                            url: '/admin/occurrences/assigned_operator',
                            data: "ids="+ ids
                            + "&operator_id=" +$('.select_operator_id').val()
                            + "&client_number=" + $("#client_number").val(),

                            success: function( data ){
                                // console.log(data);
                                if(data.retorno = 1){
                                    alert(data.mensagem);
                                    location.reload(true);
                                }else{
                                    alert("Ocorreu algum erro, tente novamente a operação");
                                    location.reload();
                                }
                            },
                            error: function (){
                                alert("Ocorreu um erro inesperado durante o processamento.");
                            }
                        });
                    }
                }
            });
        });

    </script>
@endsection
