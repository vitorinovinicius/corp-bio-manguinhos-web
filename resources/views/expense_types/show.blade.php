@extends('layouts.frest_template')

@section('content-header')
    <div class="content-header-left col-10 mb-2 mt-1">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h5 class="content-header-title float-left pr-1 mb-0">Despesa / Exibir #{{$expenseType->id}}</h5>
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb p-0 mb-0">
                        <li class="breadcrumb-item"><i class="bx bx-home-alt"></i> Home</li>
                        <li class="breadcrumb-item">Despesa</li>
                        <li class="breadcrumb-item active">Exibir</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    @if($expenseType->contractor_id || \Defender::hasRole("superuser"))
        <div class="col-2 d-flex justify-content-end align-items-center">
            <form action="{{ route('expense_types.destroy', $expenseType->uuid) }}" method="POST" style="display: inline;" onsubmit="if(confirm('Deseja realmente excluir esse item?')) { return true } else {return false };">
                <input type="hidden" name="_method" value="DELETE">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="btn-group pull-right" role="group" aria-label="...">
                    @shield('expense_type.edit')
                    <a class="btn btn-warning btn-group" role="group" href="{{route('expense_types.edit', $expenseType->uuid)}}"><i class="bx bx-edit"></i> Editar</a>
                    @endshield
                    @shield('repayment.destroy')
                    <button type="submit" class="btn btn-danger">Excluir <i class="bx bx-trash"></i></button>
                    @endshield
                </div>
            </form>
        </div>
    @endif

@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="box-title">Dados da dispesa</h3>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Empreiteira</label>
                                    <p class="form-control-static">{{optional($expenseType->contractor)->name}}</p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Dispesa</label>
                                    <p class="form-control-static">{{$expenseType->name}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    @if(strpos(URL::previous(), route('expense_types.index')) !== false)
        <a class="btn btn-primary" href="{{ URL::previous() }}"><i class="bx bx-arrow-back"></i> Voltar</a>
    @else
        <a class="btn btn-primary" href="{{ route('expense_types.index') }}"><i class="bx bx-arrow-back"></i> Voltar</a>
    @endif

@endsection
