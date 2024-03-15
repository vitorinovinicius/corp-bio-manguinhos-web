@extends('layouts.adminlte')
@section('css')
<!-- DataTables -->
<link rel="stylesheet" href="/js/datatables/dataTables.bootstrap.css">
@endsection
@section('header')
<div class="page-header clearfix">
    <h3>
        Conclusão - Comunicação
    </h3>
</div>
@endsection

@section('content')
@include('messages')
<div class="row">
    <div class="col-md-12">
        <div class="box box-danger box-solid">
            <div class="box-header">
                <h3 class="box-title">Listagem dos itens</h3>
            </div>
            <div class="box-body table-responsive">
                @if($financial_communications->count())
                <table class="table table-condensed table-striped table-sm table-hover">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Mensagem do financeiro</th>
                        <th>Usuário</th>
                        <th>Mensagem</th>
                        <th>Status</th>

                        <th class="text-right">OPÇÕES</th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach($financial_communications as $financial_communication)
                        <tr>
                            <td>{{$financial_communication->id}}</td>
                            <td>{{$financial_communication->financial_id}}</td>
                            <td>{{$financial_communication->user->name}}</td>
                            <td>{{$financial_communication->message}}</td>
                            <td>{{$financial_communication->status()}}</td>
                            <td class="text-right">
                                @shield('financial_communications.show')
                                <a class="btn btn-xs btn-primary" href="{{ route('financial_communications.show', $financial_communication->uuid) }}"><i class="bx bx-eye-open"></i> Exibir</a>
                                @endshield
                                @shield('financial_communications.edit')
                                <a class="btn btn-xs btn-warning" href="{{ route('financial_communications.edit', $financial_communication->uuid) }}"><i class="bx bx-edit"></i> Editar</a>
                                @endshield
                                @shield('financial_communications.destroy')
                                <form action="{{ route('financial_communications.destroy', $financial_communication->uuid) }}" method="POST" style="display: inline;" onsubmit="if(confirm('Deseja realmente excluir esse item?')) { return true } else {return false };">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <button type="submit" class="btn btn-xs btn-danger"><i class="bx bx-trash"></i> Excluir</button>
                                </form>
                                @endshield
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                {!! $financial_communications->render() !!}
                @else
                <h3 class="text-center alert alert-info">Vazio!</h3>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection
