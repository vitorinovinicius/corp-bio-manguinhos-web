@extends('layouts.adminlte')
@section('css')
@endsection
@section('header')
    <h1>
        Administrativo
        <small>Bio-Manguinhos</small>
    </h1>
    <ol class="breadcrumb">
        <li><i class="bx bx-dashboard"></i> Home</li>
    </ol>

@endsection

@section('content')
    @include('error')

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-danger">
                    <div class="box-header">Valor</div>
                </div>
            </div>
        </div>

    </section>
@endsection
@section('scripts')
@endsection
