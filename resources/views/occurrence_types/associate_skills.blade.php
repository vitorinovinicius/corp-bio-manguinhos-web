@extends('layouts.frest_template')
@section('css')
    <!-- Select2 -->
    <link rel="stylesheet" href="/bower_components/AdminLTE/plugins/select2/select2.min.css">
@endsection

@section('content-header')
    <div class="content-header-left col-10 mb-2 mt-1">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h5 class="content-header-title float-left pr-1 mb-0">Tipo de OS - {{ $occurrence_type->name }} - Atribuir Habilidades</h5>
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb p-0 mb-0">
                        <li class="breadcrumb-item"><i class="bx bx-home-alt"></i> Home</li>
                        <li class="breadcrumb-item">Tipo de OS</li>
                        <li class="breadcrumb-item active">Atribuir Habilidades</li>
                    </ol>
                </div>
            </div>
        </div>
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
                <div class="card-content collapse show">
                    <div class="card-body">
                        <form class="form form-vertical form_export" method="GET">
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-1">
                                        <div class="form-group">
                                            <label>ID</label>
                                            <input class="form-control" type="text" name="id" id="id" placeholder="ID" value="{{ app('request')->input('id') }}">
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label>Nome</label>
                                            <input class="form-control" type="text" name="name" id="search" placeholder="Nome" value="{{ app('request')->input('name') }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12 d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary " id="btn-external-filter"><i class="bx bx-search"></i> Aplicar</button>
                                        <a href="{{ route('occurrence_types.associate.skill', $occurrence_type->uuid) }}" class="btn btn-link pull-right"><i class="bx bx-eraser"></i> Limpar</a>
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

    <meta name="_token" content="{!! csrf_token() !!}"/>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="box-title">Dados das Habilidades</h3>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        @if($skills->count())
                            <div class="row">
                                <div class="col-12">
                                    <a class="btn btn-warning pull-right btn-attr-operator" href="#" id="btn-attr-operator"><i class="bx bx-plus"></i> Associar</a>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-condensed table-striped table-sm table-hover table-operator">
                                    <thead>
                                    <tr>
                                        <th><input type="checkbox" id="check_all" class="cs_checkbox"></th>
                                        <th>ID</th>
                                        <th>Nome</th>
                                        <th>Descrição</th>
                                        <th class="text-right">OPÇÕES</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    @foreach($skills as $skill)
                                        <tr>
                                            <td>
                                                <input name="ids[]" class="ids_check cs_checkbox" type="checkbox" value="{{$skill->id}}">
                                            </td>
                                            <td>{{$skill->id}}</td>
                                            <td>{{$skill->name}}</td>
                                            <td>{{$skill->description}}</td>

                                            <td class="text-right">
                                                @shield('skill.show')
                                                <a href="{{ route('skills.show', $skill->uuid) }}" class="btn btn-icon btn-sm btn-primary" data-toggle="tooltip" data-placement="left" title="Exibir"><i class="bx bx-book-open"></i></a>
                                                @endshield
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>

                            {!! $skills->render() !!}


                            <div class="row">
                                <div class="col-12">
                                    <a class="btn btn-warning pull-right btn-attr-operator" href="#" id="btn-attr-operator"><i class="bx bx-plus"></i> Associar</a>
                                </div>
                            </div>
                        @else
                            <h3 class="text-center alert alert-info">Não há itens cadastrados!</h3>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <a href="{{ route('occurrence_types.show', $occurrence_type->uuid) }}" class="btn btn-primary pull-right"><i class="bx bx-fast-backward"></i> Voltar</a>

@endsection
@section('scripts')
    <!-- Select2 -->
    <script src="/bower_components/AdminLTE/plugins/select2/select2.full.min.js"></script>
    <script nonce="{{ csp_nonce() }}">
        $(function () {
            //Initialize Select2 Elements
            $(".select2").select2({
                placeholder: "Selecione",
                allowClear: true
            });

            $(document).on('click', '#check_all', function () {
                if ($(this).prop('checked')) {
                    $('.ids_check').prop('checked', true);
                } else {
                    $('.ids_check').prop('checked', false);
                }
            });

            $(document).on('click', '.btn-attr-operator', function (e) {
                e.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                })
                var ids = [];
                $.each($('.table-operator tbody :checked'), function (i, v) {
                    ids.push($(v).val())
                });
                if (ids.length == 0) {
                    alert('Selecione pelo menos um item');
                } else {
                    jQuery.ajax({
                        type: 'POST',
                        url: '{!!  route('occurrence_types.associate.skill.store', [$occurrence_type->uuid, 'flag'=> 1]) !!} ',
                        data: "ids=" + ids,

                        success: function (data) {
                            if (data.retorno = 1) {
                                alert(data.mensagem);
                                location.reload(true);
                            } else {
                                alert("Ocorreu algum erro, tente novamente a operação \n " + data.mensagem);
                                // location.reload();
                            }
                        },
                        error: function () {
                            alert("Ocorreu um erro inesperado durante o processamento!\n Recarrege a página e tente novamente.");
                        }
                    });
                }
            });
        });

    </script>
@endsection
