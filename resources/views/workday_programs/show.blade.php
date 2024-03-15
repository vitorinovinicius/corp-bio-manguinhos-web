@extends('layouts.frest_template')

@section('content-header')
    <div class="content-header-left col-10 mb-2 mt-1">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h5 class="content-header-title float-left pr-1 mb-0">Programa da jornada de trabalho / Exibir #{{$workdayPrograms->id}}</h5>
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb p-0 mb-0">
                        <li class="breadcrumb-item"><i class="bx bx-home-alt"></i> Home</li>
                        <li class="breadcrumb-item">Programa da jornada de trabalho</li>
                        <li class="breadcrumb-item active">Exibir</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="col-2 d-flex justify-content-end align-items-center">
        <form action="{{ route('workday_programs.destroy', $workdayPrograms->uuid) }}" method="POST" style="display: inline;" onsubmit="if(confirm('Deseja realmente excluir esse item?')) { return true } else {return false };">
            <input type="hidden" name="_method" value="DELETE">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="btn-group pull-right" role="group" aria-label="...">
                @shield('workday.edit')
                <a class="btn btn-warning btn-group" role="group" href="{{route('workday_programs.edit', $workdayPrograms->uuid)}}"><i class="bx bx-edit"></i> Editar</a>
                @endshield
                @shield('workday.destroy')
                <button type="submit" class="btn btn-danger">Excluir <i class="bx bx-trash"></i></button>
                @endshield
            </div>
        </form>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="box-title">Dia de trabaho</h3>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <div class="row">                            
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Jornada</label>
                                    <p class="form-control-static" >{{$workdayPrograms->workday->name}}</p>                                        
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Dia da semana</label>
                                    <p class="form-control-static" >{{weekDay($workdayPrograms->day)}}</p>                                        
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Hora</label>
                                    <p class="form-control-static" >{{$workdayPrograms->hour}}</p>                                        
                                </div>
                            </div>
                        </div>   
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if(strpos(URL::previous(), route('workday.index')) !== false)
        <a class="btn btn-primary" href="{{ URL::previous() }}"><i class="bx bx-arrow-back"></i> Voltar</a>
    @else
        <a class="btn btn-primary" href="{{ route('workday.index') }}"><i class="bx bx-arrow-back"></i> Voltar</a>
    @endif

@endsection
