@extends('layouts.adminlte')
@section('header')
<div class="page-header">
        <h3>Associação de formulário / Exibir #{{$occurrence_type_form->id}}</h3>
        <form action="{{ route('occurrence_type_forms.destroy', $occurrence_type_form->uuid) }}" method="POST" style="display: inline;" onsubmit="if(confirm('Deseja realmente excluir esse item?')) { return true } else {return false };">
            <input type="hidden" name="_method" value="DELETE">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="btn-group pull-right" role="group" aria-label="...">
                @shield('occurrence_type_forms.edit')
                    <a class="btn btn-warning btn-group" role="group" href="{{ route('occurrence_type_forms.edit', $occurrence_type_form->uuid) }}"><i class="bx bx-edit"></i> Editar</a>
                @endshield
                @shield('occurrence_type_forms.destroy')
                    <button type="submit" class="btn btn-danger">Excluir <i class="bx bx-trash"></i></button>
                @endshield
            </div>
        </form>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-default">
                <div class="box-body">
                    <div class="form-group col-md-12">
                        <label for="nome">ID</label>
                        <div class="form-control input-static">{{$occurrence_type_form->id}}</div>
                    </div>
                    <div class="form-group col-md-12">
                        <label for="occurrence_type_id">OS</label>
                        <div class="form-control input-static">{{ $occurrence_type_form->occurrence_type->name }}</div>
                    </div>
                    <div class="form-group col-md-12">
                        <label for="form_id">Formulário</label>
                        <div class="form-control input-static">{{ $occurrence_type_form->form->name }}</div>
                    </div>
                    <div class="form-group col-md-12">
                        <label for="form_id">Obrigatório</label>
                        <div class="form-control input-static">{{ sim_nao($occurrence_type_form->is_required) }}</div>
                    </div>

                </div>
                <a class="btn btn-link" href="{{ route('occurrence_type_forms.index') }}"><i class="bx bx-arrow-back"></i>  Voltar</a>
            </div>
        </div>
    </div>

@endsection
