@extends('layouts.frest_template')
@section('title','- Serviços / Todos')

@section('content-header')
    <div class="content-header-left col-10 mb-2 mt-1">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h5 class="content-header-title float-left pr-1 mb-0">Serviços - Todos <small>({{$occurrences_all}})</small></h5>
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb p-0 mb-0">
                        <li class="breadcrumb-item"><i class="bx bx-home-alt"></i> Home</li>
                        <li class="breadcrumb-item">Serviços</li>
                        <li class="breadcrumb-item active">Todos - <small>Lista todas as Ordens de Serviços</small></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="col-2 d-flex justify-content-end align-items-center">
        @shield('occurrence.create')
        <a class="btn btn-success pull-right" href="{{ route('occurrences.create') }}"><i class="bx bx-plus"></i> Novo</a>
        @endshield
    </div>
@endsection

@section('content')
    @include('messages')
    @include('error')
    @include('helpers/filter_occurrences')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="box-title">Serviços - Todos</h3>
                </div>
                @include('occurrences.helpers.list_default')
            </div>
        </div>
    </div>

    @include('occurrences.includes.modal_information')
@endsection
