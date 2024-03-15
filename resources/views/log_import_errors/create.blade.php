@extends('layouts.adminlte')
@section('css')
@endsection
@section('header')
    <div class="page-header">
        <h3><i class="bx bx-map"></i> Erros de importação / Criar </h3>
    </div>
    <ol class="breadcrumb">
        <li><a href="/admin"><i class="bx bx-dashboard"></i> Home</a></li>
        <li> Erros de importação</li>
        <li class="active">Criar</li>
    </ol>
@endsection

@section('content')
    @include('error')

    <div class="col-md-12">
        <!-- Horizontal Form -->
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">Criar nova área</h3>
            </div>
            <form action="{{ route('log_import_errors.store') }}" method="POST">
                <div class="box-body">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    <div class="form-group">
                        <label for="log_import_id">Id de importação</label>
                        <div><input type="text" class="form-control" name="log_import_id" placeholder="Id de importação"></div>
                    </div>
                    <div class="form-group">
                        <label for="line_number">Nº da linha</label>
                        <div><input type="text" class="form-control" name="line_number" placeholder="Nº da linha"></div>
                    </div>
                    <div class="form-group">
                        <label for="line_detail">Detalhe da linha</label>
                        <div><textarea class="form-control" name="line_detail" placeholder="Detalhe da linha"></textarea></div>
                    </div>
                    <div class="form-group">
                        <label for="error_message">Mensagem de erro</label>
                        <div><textarea class="form-control" name="error_message" placeholder="Mensagem de erro"></textarea></div>
                    </div>
                </div>


                <!-- /.box-body -->
                <div class="box-footer">
                    <a class="btn btn-link" href="{{ route('log_import_errors.index') }}"><i
                                class="bx bx-arrow-back"></i> Voltar</a>
                    <button type="submit" class="btn btn-primary  pull-right">Criar</button>
                </div>
            </form>
            <!-- /.box-footer-->
        </div>
    </div>
@endsection
