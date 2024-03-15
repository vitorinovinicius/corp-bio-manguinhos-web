@extends('layouts.frest_template')
@section('css')
    <!-- Select2 -->
    <link rel="stylesheet" href="/bower_components/AdminLTE/plugins/select2/select2.min.css">
@endsection

@section('content-header')
    <div class="content-header-left col-12 mb-2 mt-1">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h5 class="content-header-title float-left pr-1 mb-0">Jornada de trabalho / Editar #{{$workday->id}}</h5>
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb p-0 mb-0">
                        <li class="breadcrumb-item"><i class="bx bx-home-alt"></i> Home</li>
                        <li class="breadcrumb-item">Jornada de trabalho</li>
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
                    <h3 class="box-title">Editar jornada de trabalho</h3>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <form class="form form-vertical" action="{{ route('workday.update', $workday->uuid) }}" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="_method" value="PUT">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label>Nome</label>
                                            <input type="text" class="form-control" id="name" name="name" value="{{ (old('name'))? old('name') : $workday->name }}" placeholder="Name">
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label>Status</label>
                                            <select class="form-control select2" name="status" required data-placeholder="Selecione status" required>
                                                <option value="1" @if($workday->status == 1) selected @endif>Ativo</option>
                                                <option value="0" @if($workday->status == 0) selected @endif>Inativo</option>
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
                            <div class="form-body">
                                @foreach($workday->workday_programs as $programs)
                                    <div class="row d-flex align-items-center">
                                        <div class="col-2">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="{{$programs->day}}" name="week[{{$programs->day}}]"  @if($programs->hour != 0) checked @endif>
                                                <label class="form-check-label" for="dom" >{{weekDay($programs->day)}}</label>
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <div class="form-group">
                                                <input type="time" class="form-control hour" name="week[{{$programs->day}}][working_day_start]"  placeholder="Inicio da jorada" data-name="{{$programs->day}}" @if($programs->working_day_start == 0) readonly @endif value="{{$programs->working_day_start}}" >
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <div class="form-group">
                                                <input type="time" class="form-control hour" name="week[{{$programs->day}}][lunch_start]" placeholder="Inicio do almoço" data-name="{{$programs->day}}" @if($programs->lunch_start == 0) readonly @endif value="{{$programs->lunch_start}}" >
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <div class="form-group">
                                                <input type="time" class="form-control hour" name="week[{{$programs->day}}][lunch_end]" placeholder="Termino do almoço" data-name="{{$programs->day}}" @if($programs->lunch_end == 0) readonly @endif value="{{$programs->lunch_end}}" >
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <div class="form-group">
                                                <input type="time" class="form-control hour" name="week[{{$programs->day}}][working_day_end]" placeholder="Termino do almoço" data-name="{{$programs->day}}" @if($programs->working_day_end == 0) readonly @endif value="{{$programs->working_day_end}}" >
                                            </div>
                                        </div>

                                    </div>
                                @endforeach

                                <div class="row">
                                    <div class="col-12 d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary">Salvar</button>
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
    <!-- Datepicker -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.0/js/bootstrap-datepicker.min.js"></script>
    <script nonce="{{ csp_nonce() }}">
        $(".form-check-input").click(function(){
            var id = $(this).attr("id");
            if($(this).is(':checked') == true){
             $("[data-name='"+id+"']").removeAttr('readonly');
             $("[data-name='"+id+"']").attr('required', true);
            }else{
             $("[data-name='"+id+"']").val(0);
             $("[data-name='"+id+"']").attr('readonly', true);
            }
         })
    </script>
@endsection
