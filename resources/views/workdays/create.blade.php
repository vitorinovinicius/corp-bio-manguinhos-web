@extends('layouts.frest_template')
@section('css')
    <!-- Select2 -->
    <link rel="stylesheet" href="/bower_components/AdminLTE/plugins/select2/select2.min.css">

@endsection
@section('script')

@endsection

@section('content-header')
    <div class="content-header-left col-12 mb-2 mt-1">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h5 class="content-header-title float-left pr-1 mb-0">Jornada de trabalho / Criar</h5>
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb p-0 mb-0">
                        <li class="breadcrumb-item"><i class="bx bx-home-alt"></i> Home</li>
                        <li class="breadcrumb-item">Jornada de trabalho</li>
                        <li class="breadcrumb-item active">Criar</li>
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
                    <h3 class="box-title">Criar Jornada de trabalho</h3>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <form class="form form-vertical" action="{{ route('workday.store') }}" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label>Nome</label>
                                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" placeholder="Jornada">
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label>Status</label>
                                            <div>
                                                <select class="form-control select2" name="status" required data-placeholder="Selecione o status" required>
                                                    <option></option>
                                                    <option value="1">Ativo</option>
                                                    <option value="0">Inativo</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                    </div>

                    <div class="card-header">
                        <h4 class="box-title">Programação da jornada de trabalho</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form class="form form-vertical" action="{{ route('workday_programs.store') }}" method="POST" enctype="multipart/form-data">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <div class="form-body">
                                    <div class="row d-flex align-items-center">
                                        <div class="col-2"><div class="form-group">Dia da semana</div></div>
                                        <div class="col-2"><div class="form-group">Início da Jornada</div></div>
                                        <div class="col-2"><div class="form-group">Início do Almoço</div></div>
                                        <div class="col-2"><div class="form-group">Fim do Almoço</div></div>
                                        <div class="col-2"><div class="form-group">Fim da Jornada</div></div>
                                    </div>
                                    @foreach($days_week as $key=>$day)
                                        <div class="row d-flex align-items-center">
                                            <div class="col-2">
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" id="{{ $day["name_min"] }}" name="week[{{ $key }}]" value="{{ $day["name_min"] }}">
                                                    <label class="form-check-label" for="{{ $day["name_min"] }}">{{ $day["name"] }}</label>
                                                </div>
                                            </div>
                                            <div class="col-2">
                                                <div class="form-group">
                                                    <input type="text" class="form-control text" name="week[{{ $key }}][working_day_start]" id="{{ $day["name_min"] }}_working_day_start" placeholder="Inicio da jorada" data-name="{{ $day["name_min"] }}" readonly>
                                                    <input type="time" class="form-control hour" style="display: none" name="week[{{ $key }}][working_day_start]" id="{{ $day["name_min"] }}_working_day_start_hour" placeholder="Inicio da jorada" data-name="{{ $day["name_min"] }}" readonly>
                                                </div>
                                            </div>
                                            <div class="col-2">
                                                <div class="form-group">
                                                    <input type="text" class="form-control text" name="week[{{ $key }}][lunch_start]" id="{{ $day["name_min"] }}_lunch_start" placeholder="Inicio do almoço" data-name="{{ $day["name_min"] }}" readonly>
                                                    <input type="time" class="form-control hour" style="display: none" name="week[{{ $key }}][lunch_start]" id="{{ $day["name_min"] }}_lunch_start_hour" placeholder="Inicio do almoço" data-name="{{ $day["name_min"] }}" readonly>
                                                </div>
                                            </div>
                                            <div class="col-2">
                                                <div class="form-group">
                                                    <input type="text" class="form-control text" name="week[{{ $key }}][lunch_end]" id="{{ $day["name_min"] }}_lunch_end" placeholder="Término do almoço" data-name="{{ $day["name_min"] }}" readonly>
                                                    <input type="time" class="form-control hour" style="display: none" name="week[{{ $key }}][lunch_end]" id="{{ $day["name_min"] }}_lunch_end_hour" placeholder="Término do almoço" data-name="{{ $day["name_min"] }}" readonly>
                                                </div>
                                            </div>
                                            <div class="col-2">
                                                <div class="form-group">
                                                    <input type="text" class="form-control text" name="week[{{ $key }}][working_day_end]" id="{{ $day["name_min"] }}_working_day_end" placeholder="Término da jornada" data-name="{{ $day["name_min"] }}" readonly>
                                                    <input type="time" class="form-control hour" style="display: none" name="week[{{ $key }}][working_day_end]" id="{{ $day["name_min"] }}_working_day_end_hour" placeholder="Término da jornada" data-name="{{ $day["name_min"] }}" readonly>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach

                                    <div class="row">
                                        <div class="col-12 d-flex justify-content-end">
                                            <button type="submit" class="btn btn-primary">Criar</button>
                                            <a class="btn btn-link pull-right"
                                               href="{{ route('workday.index') }}"><i
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
        <!-- Select2 -->
            <script src="/bower_components/AdminLTE/plugins/select2/select2.full.min.js"></script>
            <script nonce="{{ csp_nonce() }}">

                $(function () {
                    //Initialize Select2 Elements
                    $(".select2").select2({
                        allowClear: true,
                    });
                });

                $(".form-check-input").click(function () {
                    var id = $(this).attr("id");
                    if ($(this).is(':checked') == true) {
                        $("[data-name='" + id + "']").removeAttr('readonly');
                        $("[data-name='" + id + "']").attr('required', true);
                        $(".text").focus(function () {
                            var id = $(this).attr("id");
                            console.log(id);
                            $('#' + id).hide().prop('required', false);
                            $("#" + id + "_hour").focus().show();

                        });
                    } else {
                        $("[data-name='" + id + "']").val('');
                        $("[data-name='" + id + "']").attr('readonly', true);
                    }


                });


            </script>

@endsection
