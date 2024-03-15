@extends('layouts.frest_template')

@section('content-header')
    <div class="content-header-left col-12 mb-2 mt-1">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h5 class="content-header-title float-left pr-1 mb-0">Serviços - Recusadas pelo administrativo
                    <small>({{$occurrences_all}})</small></h5>
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb p-0 mb-0">
                        <li class="breadcrumb-item"><i class="bx bx-home-alt"></i> Home</li>
                        <li class="breadcrumb-item">Conclusão</li>
                        <li class="breadcrumb-item active">Recusadas pelo administrativo -
                            <small>Lista todas as Ocorrências que já recusadas pelo administrativo</small></li>
                    </ol>
                </div>
            </div>
        </div>
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
                    <h3 class="box-title">Serviços - Recusadas pelo administrativo</h3>
                </div>
                @include('occurrences.helpers.list_default')
            </div>
        </div>
    </div>

    @include('occurrences.includes.modal_information')
@endsection
