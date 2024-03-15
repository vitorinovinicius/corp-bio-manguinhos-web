@extends('layouts.frest_template')
@section('css')
    <!-- Select2 -->
    <link rel="stylesheet" href="/bower_components/AdminLTE/plugins/select2/select2.min.css">
@endsection

@section('content-header')
    <div class="content-header-left col-12 mb-2 mt-1">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h5 class="content-header-title float-left pr-1 mb-0">Programa da jornada de trabalho / Criar</h5>
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb p-0 mb-0">
                        <li class="breadcrumb-item"><i class="bx bx-home-alt"></i> Home</li>
                        <li class="breadcrumb-item">Programa da jornada de trabalho</li>
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
                    <h3 class="box-title">Programa da jornada de trabalho</h3>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <form class="form form-vertical" action="{{ route('workday_programs.store') }}" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label>Jornada</label>
                                            <select class="form-control select2" name="workday_id" required data-placeholder="Selecione uma jornada" required>
                                                <option></option>
                                                @forelse($workdays as $workday)
                                                    <option value="{{$workday->id}}">{{$workday->name}}</option>
                                                @empty
                                                @endforelse
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row d-flex align-items-center">
                                    <div class="col-2">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" id="dom" name="week[1]" value="1">
                                            <label class="form-check-label" for="dom">Domingo</label>
                                        </div>
                                    </div>
                                    <div class="col-2">
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="week[1]" id="" placeholder="Horas">
                                        </div>
                                    </div>
                                </div>
                                <div class="row d-flex align-items-center">
                                    <div class="col-2">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" id="seg" name="week[2]">
                                            <label class="form-check-label" for="seg">Segunda-feira</label>
                                        </div>
                                    </div>
                                    <div class="col-2">
                                        <div class="form-group">
                                            <input type="text" class="form-control"  name="week[2]" id="" placeholder="Horas">
                                        </div>
                                    </div>
                                </div>
                                <div class="row d-flex align-items-center">
                                    <div class="col-2">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" id="ter" name="week[3]">
                                            <label class="form-check-label" for="ter">Terça-feira</label>
                                        </div>
                                    </div>
                                    <div class="col-2">
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="week[3]" id="" placeholder="Horas">
                                        </div>
                                    </div>
                                </div>
                                <div class="row d-flex align-items-center">
                                    <div class="col-2">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" id="qua" name="week[4]">
                                            <label class="form-check-label" for="qua">Quarta-feira</label>
                                        </div>
                                    </div>
                                    <div class="col-2">
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="week[4]" id="" placeholder="Horas">
                                        </div>
                                    </div>
                                </div>

                                <div class="row d-flex align-items-center">
                                    <div class="col-2">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" id="qui" name="week[5]">
                                            <label class="form-check-label" for="qui" >Quinta-feira</label>
                                        </div>
                                    </div>
                                    <div class="col-2">
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="week[5]" id="" placeholder="Horas">
                                        </div>
                                    </div>
                                </div>
                                <div class="row d-flex align-items-center">
                                    <div class="col-2">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" id="sex" name="week[6]">
                                            <label class="form-check-label" for="sex">Sexta-feira</label>
                                        </div>
                                    </div>
                                    <div class="col-2">
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="week[6]" id="" placeholder="Horas">
                                        </div>
                                    </div>
                                </div>
                                <div class="row d-flex align-items-center">
                                    <div class="col-2">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" id="sab" name="week[7]">
                                            <label class="form-check-label" for="sab">Sábado</label>
                                        </div>
                                    </div>
                                    <div class="col-2">
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="week[7]" id="" placeholder="Horas">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary">Criar</button>
                                        <a class="btn btn-link pull-right"
                                           href="{{ route('workday_programs.index') }}"><i
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

    </script>

@endsection
