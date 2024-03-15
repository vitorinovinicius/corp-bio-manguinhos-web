@extends('layouts.frest_template')

@section('header')
    <div class="page-header clearfix">
        <h2>
            Tipos de Ocorrências
            @shield('occurrence_type.create')
                <a class="btn btn-success pull-right" href="{{ route('occurrence_types.create') }}"><i class="bx bx-plus"></i> Novo </a>
            @endshield
        </h2>
    </div>
@endsection

@section('content-header')
    <div class="content-header-left col-10 mb-2 mt-1">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h5 class="content-header-title float-left pr-1 mb-0">Tipos de Ocorrências</h5>
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb p-0 mb-0">
                        <li class="breadcrumb-item"><i class="bx bx-home-alt"></i> Home</li>
                        <li class="breadcrumb-item active">Tipos de Ocorrências</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="col-2 d-flex justify-content-end align-items-center">
        @shield('occurrence_type.create')
        <a class="btn btn-success pull-right" href="{{ route('occurrence_types.create') }}"><i class="bx bx-plus"></i> Novo</a>
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
                    <h3 class="box-title">Tipos de Ocorrências</h3>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        @if($occurrence_types->count())
                            <div class="table-responsive">
                                <table class="table table-condensed table-striped table-sm table-hover">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nome</th>
                                        <th>Descrição</th>
                                        @is('superuser')<th>Empresa</th>@endis
                                        <th>Status</th>
                                        <th>Tempo médio execução</th>
                                        <th>Qtd Formulários</th>

                                        <th>Criado</th>
                                        {{--<th>Modificado</th>--}}

                                        <th class="text-right">OPÇÕES</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    @foreach($occurrence_types as $occurrence_type)
                                        <tr>
                                            <td>{{$occurrence_type->id}}</td>
                                            <td>{{$occurrence_type->name}}</td>
                                            <td>{{$occurrence_type->description}}</td>
                                            @is('superuser')<td>{{optional($occurrence_type->contractor)->name}}</td>@endis
                                            <td>{{ativo_inativo($occurrence_type->status)}}</td>
                                            <td>{{$occurrence_type->average_time}}</td>
                                            <td>{{$occurrence_type->forms->count()}}</td>
                                            <td>{{ date('d/m/Y H:i:s', strtotime($occurrence_type->created_at)) }}</td>
                                            {{--                                    <td>{{ date('d/m/Y H:i:s', strtotime($occurrence_type->updated_at)) }}</td>--}}

                                            <td class="text-right">
                                                @shield('occurrence_type.show')
                                                <a href="{{ route('occurrence_types.show', $occurrence_type->uuid) }}" class="btn btn-icon btn-sm btn-primary" data-toggle="tooltip" data-placement="left" title="Exibir"><i class="bx bx-book-open"></i></a>
                                                @endshield
                                                @shield('occurrence_type.edit')
                                                <a href="{{ route('occurrence_types.edit', $occurrence_type->uuid) }}" class="btn btn-icon btn-sm btn-warning" data-toggle="tooltip" data-placement="left" title="Editar"><i class="bx bx-pencil"></i></a>
                                                @endshield
                                                @shield('occurrence_type.destroy')
                                                <form action="{{ route('occurrence_types.destroy', $occurrence_type->uuid) }}"
                                                      method="POST" style="display: inline;"
                                                      onsubmit="if(confirm('Deseja deletar esse item?')) { return true } else {return false };">
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                    <button type="submit" class="btn btn-icon btn-sm btn-danger" data-toggle="tooltip" data-placement="left" title="Deletar"><i class="bx bx-trash"></i></button>
                                                </form>
                                                @endshield
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            {!! $occurrence_types->render() !!}
                        @else
                            <h3 class="text-center alert alert-info">Vazio!</h3>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
