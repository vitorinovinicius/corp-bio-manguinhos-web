@extends('layouts.frest_template')

@section('content-header')
    <div class="content-header-left col-md-9 mb-2 mt-1">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h5 class="content-header-title float-left pr-1 mb-0">Jornada de trabalho / Exibir #{{$workday->id}}</h5>
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb p-0 mb-0">
                        <li class="breadcrumb-item"><i class="bx bx-home-alt"></i> Home</li>
                        <li class="breadcrumb-item">Jornada de trabalho</li>
                        <li class="breadcrumb-item active">Exibir</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 ">

        <div class="btn-group pull-right" role="group" aria-label="...">
            @shield('workday.edit')
            <a class="btn btn-warning " role="group" href="{{route('workday.edit', $workday->uuid)}}"><i class="bx bx-edit"></i> Editar</a>
            @endshield
            @shield('workday.destroy')
            <form action="{{ route('workday.destroy', $workday->uuid) }}" method="POST" style="display: inline;" onsubmit="if(confirm('Deseja realmente excluir esse item?')) { return true } else {return false };">
                <input type="hidden" name="_method" value="DELETE">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <button type="submit" class="btn btn-danger pull-right"><i class="bx bx-trash"></i> Excluir </button>
            </form>
            @endshield
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="box-title">Jornada de trabaho</h3>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <div class="row">
                            @is('superuser')
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Empreiteira</label>
                                    <p class="form-control-static">{{$workday->contractor->name}}</p>
                                </div>
                            </div>
                            @endis
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Nome</label>
                                    <p class="form-control-static">{{$workday->name}}</p>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Status</label>
                                    <p class="form-control-static">{{$workday->getStatus()}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-header">
                    <h4 class="box-title">Programa da jornada de trabalho</h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        @if($workday->workday_programs->count())
                            <div class="table-responsive">
                                <table class="table table-condensed table-striped table-sm table-hover">
                                    <thead>
                                    <tr>
                                        <th></th>
                                        <th>Dia</th>
                                        <th>Inicio da jorada</th>
                                        <th>Inicio do almoço</th>
                                        <th>Término do almoço</th>
                                        <th>Término da jornada</th>
                                        <th>Hora</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    @foreach($workday->workday_programs as $workday_program)
                                        <tr>
                                            <td>
                                                <input type="checkbox" {{($workday_program->hour != 0) ? 'checked' : '' }} disabled>
                                            </td>
                                            <td>{{weekDay($workday_program->day)}}</td>
                                            <td>{{$workday_program->working_day_start ? $workday_program->working_day_start : '00:00:00'}}</td>
                                            <td>{{$workday_program->lunch_start ? $workday_program->lunch_start : '00:00:00'}}</td>
                                            <td>{{$workday_program->lunch_end ? $workday_program->lunch_end : '00:00:00'}}</td>
                                            <td>{{$workday_program->working_day_end ? $workday_program->working_day_end : '00:00:00'}}</td>
                                            <td>{{$workday_program->hour}} hora(s)</td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                        @else
                            <h3 class="text-center alert alert-info">Vazio!</h3>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>

    <a class="btn btn-primary" href="{{ route('workday.index') }}"><i class="bx bx-arrow-back"></i> Voltar</a>

@endsection
