@extends('layouts.adminlte')
@section('header')
    <div class="page-header">
        <h3>Conclusão - Comunicação / Exibir #{{$financial_communication->id}}</h3>
        <form action="{{ route('financial_communications.destroy', $financial_communication->uuid) }}" method="POST" style="display: inline;" onsubmit="if(confirm('Deseja realmente excluir esse item?')) { return true } else {return false };">
            <input type="hidden" name="_method" value="DELETE">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="btn-group pull-right" role="group" aria-label="...">
                @shield('financial_communications.edit')
                <a class="btn btn-warning btn-group" role="group" href="{{ route('financial_communications.edit', $financial_communication->uuid) }}"><i class="bx bx-edit"></i> Editar</a>
                @endshield
                @shield('financial_communications.destroy')
                <button type="submit" class="btn btn-danger">Excluir <i class="bx bx-trash"></i></button>
                @endshield
            </div>
        </form>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-danger box-solid">
                <div class="box-header">
                    <h3 class="box-title">Exibição</h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="form-group col-md-2">
                            <label for="nome">ID</label>
                            <div class="form-control input-static">{{$financial_communication->id}}</div>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="user_id">Usuário</label>
                            <div class="form-control input-static">{{ $financial_communication->user->name }}</div>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="status">Status</label>
                            <div class="form-control input-static">{{ $financial_communication->status() }}</div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="message">Mensagem</label>
                            <div class="form-control input-static">{!! $financial_communication->message !!}</div>
                        </div>
                    </div>

                </div>
                <a class="btn btn-link" href="{{ route('financial_communications.index') }}"><i class="bx bx-arrow-back"></i> Voltar</a>
            </div>
        </div>
    </div>

@endsection
