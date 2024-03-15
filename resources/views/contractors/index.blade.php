@extends('layouts.frest_template')
@section('css')
    <!-- DataTables -->
    <link rel="stylesheet" href="/js/datatables/dataTables.bootstrap.css">
@endsection
@section('header')
    <div class="page-header clearfix">
        <h2>
            Empreiteiras
            @shield('contractor.create')
            <a class="btn btn-success pull-right" href="{{ route('contractors.create') }}"><i class="bx bx-plus"></i> Novo</a>
            @endshield
        </h2>
    </div>
@endsection

@section('content-header')
    <div class="content-header-left col-10 mb-2 mt-1">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h5 class="content-header-title float-left pr-1 mb-0">Empresas</h5>
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb p-0 mb-0">
                        <li class="breadcrumb-item"><i class="bx bx-home-alt"></i> Home</li>
                        <li class="breadcrumb-item active">Empresas</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="col-2 d-flex justify-content-end align-items-center">
        @shield('contractor.create')
        <a class="btn btn-success pull-right" href="{{ route('contractors.create') }}"><i class="bx bx-plus"></i> Novo</a>
        @endshield
    </div>
@endsection

@section('content')
    @include('messages')
    @include('error')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="box-title">Empresas ({{$contractors->count()}})</h3>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        @if($contractors->count())
                            <div class="table-responsive">
                                <table class="table table-condensed table-striped table-sm table-hover">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nome</th>
                                        <th>Região</th>
                                        <th>Status</th>
                                        <th>SMS</th>
                                        <th>E-mail</th>
                                        <th>Visibilidade</th>
                                        <th>Limite Clientes</th>
                                        <th>Total Clientes</th>
                                        <th>Pendência Financeira</th>
                                        <th>Icone</th>
                                        {{--<th>Criado</th>--}}
                                        {{--<th>Modificado</th>--}}

                                        <th class="text-right">OPÇÕES</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    @foreach($contractors as $contractor)
                                        <tr>
                                            <td>{{$contractor->id}}</td>
                                            <td>
                                                <a class="btn-link" href="{{ route('contractors.show', $contractor->uuid) }}">{{$contractor->name}}</a>
                                            </td>
                                            <td>{{$contractor->regions->implode('name',', ')}}</td>
                                            <td>{{sim_nao($contractor->send_mail)}}</td>
                                            <td>{{sim_nao($contractor->send_sms)}}</td>
                                            <td>{{$contractor->status()}}</td>
                                            <td>{{$contractor->visibility()}}</td>
                                            <td>{{$contractor->client_limit}}</td>
                                            <td>{{$contractor->clients->count()}}</td>
                                            <td>{{$contractor->financialPendency()}}</td>

                                            <td><img src="{{$contractor->icon}}"></td>
                                            {{--                                    <td>{{ date('d/m/Y H:i:s', strtotime($contractor->created_at)) }}</td>--}}
                                            {{--                                    <td>{{ date('d/m/Y H:i:s', strtotime($contractor->updated_at)) }}</td>--}}

                                            <td class="text-right">
                                                @shield('contractor.show')
                                                <a href="{{ route('contractors.show', $contractor->uuid) }}" class="btn btn-icon btn-sm btn-primary" data-toggle="tooltip" data-placement="left" title="Exibir"><i class="bx bx-book-open"></i></a>
                                                @endshield
                                                @shield('contractor.edit')
                                                <a href="{{ route('contractors.edit', $contractor->uuid) }}" class="btn btn-icon btn-sm btn-warning" data-toggle="tooltip" data-placement="left" title="Editar"><i class="bx bx-pencil"></i></a>
                                                @endshield
                                                @shield('contractor.destroy')
                                                <form action="{{ route('contractors.destroy', $contractor->uuid) }}"
                                                      method="POST" style="display: inline;"
                                                      onsubmit="if(confirm('Deseja deletar esse item?')) { return true } else {return false };">
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                    <button type="submit" class="btn btn-icon btn-sm btn-danger" data-toggle="tooltip" data-placement="left" title="Deletar">
                                                        <i class="bx bx-trash"></i></button>
                                                </form>
                                                @endshield
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            {!! $contractors->render() !!}
                        @else
                            <h3 class="text-center alert alert-info">Vazio!</h3>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('scripts')
@endsection
