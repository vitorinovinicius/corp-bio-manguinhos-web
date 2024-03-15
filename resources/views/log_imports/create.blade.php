@extends('layouts.adminlte')
@section('css')
    <!-- Select2 -->
    <link rel="stylesheet" href="/bower_components/AdminLTE/plugins/select2/select2.min.css">
@endsection
@section('header')
    <div class="page-header">
        <h3><i class="bx bx-video-camera"></i> Log de importação / Criar </h3>
    </div>
@endsection

@section('content')
    @include('error')

     <div class="col-md-6">
        <!-- Horizontal Form -->
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">Criar um Log de importação</h3>
            </div>
            <form action="{{ route('log_imports.store') }}" method="POST">
                <div class="box-body">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    <div class="form-group">
                        <label for="user_id">Usuário</label>
                        <div>
                            <select class="form-control select2" name="user_id" required data-placeholder="Selecione um usuário" required>
                                <option></option>
                                @forelse($users as $user)
                                    <option value="{{$user->id}}">{{$user->name}}</option>
                                @empty
                                @endforelse
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name_archive">Nome do arquivo</label>
                        <div><input type="text" class="form-control" name="name_archive" value="{{ old('name_archive') }}"  placeholder="Nome do arquivo"></div>
                    </div>
                    <div class="form-group">
                        <label for="qtd_error">Qtd erros</label>
                        <div><input type="text" class="form-control" name="qtd_error" value="{{ old('qtd_error') }}"  placeholder="Qtd Erros"></div>
                    </div>
                    <div class="form-group">
                        <label for="qtd_success">Qtd oks</label>
                        <div><input type="text" class="form-control" name="qtd_success" value="{{ old('qtd_success') }}"  placeholder="Qtd oks"></div>
                    </div>
                    <div class="form-group">
                        <label for="lines">Total de linhas</label>
                        <div><input type="text" class="form-control" name="lines" value="{{ old('lines') }}"  placeholder="Total de linhas"></div>
                    </div>
                    <div class="form-group">
                        <label for="archive_path">Caminho do arquivo</label>
                        <div><input type="text" class="form-control" name="archive_path" value="{{ old('archive_path') }}"  placeholder="Caminho"></div>
                    </div>
                </div>

                <div class="box-footer">
                        <a class="btn btn-link" href="{{ route('log_imports.index') }}"><i class="bx bx-arrow-back"></i> Voltar</a>
                        <button type="submit" class="btn btn-primary pull-right">Criar</button>
                    </div>
            </form>

        </div>
    </div>
@endsection
@section('scripts')
    <!-- Select2 -->
    <script src="/bower_components/AdminLTE/plugins/select2/select2.full.min.js"></script>
    <script nonce="{{ csp_nonce() }}">
        $(function () {
            //Initialize Select2 Elements
            $(".select2").select2({
                    allowClear: true
            });
        });
    </script>
@endsection
