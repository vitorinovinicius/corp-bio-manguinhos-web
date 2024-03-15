@extends('layouts.adminlte')
@section('css')
    <!-- DataTables -->
    <link rel="stylesheet" href="/js/datatables/dataTables.bootstrap.css">
@endsection
@section('header')
    <div class="page-header clearfix">
        <h3>
            Configurações
            @shield('configurations.create')
                <a class="btn btn-success pull-right" href="{{ route('configurations.create') }}"><i class="bx bx-plus"></i> Criar</a>
            @endshield
        </h3>
    </div>
@endsection

@section('content')
    @include('messages')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-default">
                @if($configurations)
                    <table class="table table-condensed table-striped table-sm table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tipo</th>
                                <th>Empreiteira</th>
                                <th>Descrição</th>
                                <th>Chave</th>
                                <th>Valor</th>

                                <th class="text-right">OPÇÕES</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($configurations as $configuration)
                                <tr>
                                    <td>{{$configuration->id}}</td>
                                    <td>{{$configuration->tipo_user()}}</td>
                                    <td>{{optional($configuration->contractor)->name}}</td>
                                    <td>{{$configuration->description}}</td>
                                    <td>{{$configuration->config_key}}</td>
                                    <td>{{$configuration->config_value}}</td>
                                    <td class="text-right">
                                        @shield('configurations.show')
                                        <a class="btn btn-xs btn-primary" href="{{ route('configurations.show', $configuration->uuid) }}"><i class="bx bx-eye-open"></i> Exibir</a>
                                        @endshield
                                        @shield('configurations.edit')
                                        <a class="btn btn-xs btn-warning" href="{{ route('configurations.edit', $configuration->uuid) }}"><i class="bx bx-edit"></i> Editar</a>
                                        @endshield
                                        @shield('configurations.destroy')
                                        <form action="{{ route('configurations.destroy', $configuration->uuid) }}" method="POST" style="display: inline;" onsubmit="if(confirm('Deseja realmente excluir esse item?')) { return true } else {return false };">
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
{{--                    {!! $configurations->render() !!}--}}
                @else
                    <h3 class="text-center alert alert-info">Vazio!</h3>
                @endif
            </div>
        </div>
    </div>

@endsection
