@extends('layouts.frest_template')
@section('css')
    <!-- DataTables -->
    <link rel="stylesheet" href="/js/datatables/dataTables.bootstrap.css">
@endsection

@section('content-header')
    <div class="content-header-left col-10 mb-2 mt-1">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h5 class="content-header-title float-left pr-1 mb-0">Formulários</h5>
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb p-0 mb-0">
                        <li class="breadcrumb-item"><i class="bx bx-home-alt"></i> Home</li>
                        <li class="breadcrumb-item active">Formulários</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="col-2 d-flex justify-content-end align-items-center">
        @shield('form.create')
        <a class="btn btn-success pull-right" href="{{ route('forms.create') }}"><i class="bx bx-plus"></i> Novo</a>
        @endshield
    </div>
@endsection

@section('content')
    @include('messages')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="box-title">Formulários</h3>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        @if($forms->count())
                            <div class="table-responsive">
                                <table class="table table-condensed table-striped table-sm table-hover">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Titulo</th>
                                        <th>Sub-titulo</th>
                                        <th>Setor responsável</th>
                                        <th>Ano</th>

                                        {{-- <th class="text-right">OPÇÕES</th> --}}
                                    </tr>
                                    </thead>

                                    <tbody>
                                    @foreach($forms as $form)
                                        @if(!$form->sub_titulo_id)
                                            <tr>
                                                <td>{{$form->id}}</td>
                                                <td>{{ !isset($form->sub_titulo_id)?$form->descricao:''}}</td>
                                                <td>
                                                    <ul>
                                                        @foreach($form->titulo as $subtitulo)
                                                            <li>{{$subtitulo->descricao}}</li>
                                                        @endforeach
                                                    </ul>
                                                </td>
                                                <td>{{optional($form->setor)->name}}</td>
                                                <td>{{Date('Y', strtotime($form->ANO))}}</td>
                                            </tr>
                                        @endif
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>

                            {!! $forms->render() !!}
                        @else
                            <h3 class="text-center alert alert-info">Vazio!</h3>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
