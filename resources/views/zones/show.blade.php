@extends('layouts.frest_template')

@section('content-header')
    <div class="content-header-left col-md-9 mb-2 mt-1">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h5 class="content-header-title float-left pr-1 mb-0">Zona / Exibir #{{$zone->id}}</h5>
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb p-0 mb-0">
                        <li class="breadcrumb-item"><i class="bx bx-home-alt"></i> Home</li>
                        <li class="breadcrumb-item">Zona</li>
                        <li class="breadcrumb-item active">Exibir</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 ">

        <div class="btn-group pull-right" role="group" aria-label="...">
            @shield('zones.edit')
            <a class="btn btn-warning " role="group" href="{{route('zones.edit', $zone->uuid)}}"><i class="bx bx-edit"></i> Editar</a>
            @endshield
            @shield('zones.destroy')
            <form action="{{ route('zones.destroy', $zone->uuid) }}" method="POST" style="display: inline;" onsubmit="if(confirm('Deseja realmente excluir esse item?')) { return true } else {return false };">
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
                    <h3 class="box-title">Zona</h3>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-3">
                                <div class="form-group">
                                    <label>ID</label>
                                    <p class="form-control-static">{{$zone->id}}</p>
                                </div>
                            </div>
                            @is('superuser')
                            <div class="col-3">
                                <div class="form-group">
                                    <label>Empreiteira</label>
                                    <p class="form-control-static">{{$zone->contractor->name}}</p>
                                </div>
                            </div>
                            @endis
                            <div class="col-3">
                                <div class="form-group">
                                    <label>Nome</label>
                                    <p class="form-control-static">{{$zone->zone}}</p>
                                </div>
                            </div>                            
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>

    @if(strpos(URL::previous(), route('zones.index')) !== false)
        <a class="btn btn-primary" href="{{ URL::previous() }}"><i class="bx bx-arrow-back"></i> Voltar</a>
    @else
        <a class="btn btn-primary" href="{{ route('zones.index') }}"><i class="bx bx-arrow-back"></i> Voltar</a>
    @endif

@endsection
