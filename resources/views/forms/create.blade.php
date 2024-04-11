@extends('layouts.frest_template')
@section('css')
    <!-- Select2 -->
    <link rel="stylesheet" href="/bower_components/AdminLTE/plugins/select2/select2.min.css">
@endsection

@section('content-header')
    <div class="content-header-left col-12 mb-2 mt-1">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h5 class="content-header-title float-left pr-1 mb-0">Formulários / Criar</h5>
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb p-0 mb-0">
                        <li class="breadcrumb-item"><i class="bx bx-home-alt"></i> Home</li>
                        <li class="breadcrumb-item">Formulários</li>
                        <li class="breadcrumb-item active">Criar</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    @include('messages')
    @include('error')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="box-title">Criar Formulário</h3>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <form class="form form-vertical" action="{{ route('forms.store') }}" method="POST">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="type" value="1">
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label>Titulo</label>
                                            <input type="text" class="form-control" name="titulo" value="{{ old('titulo') }}" placeholder="Titulo" autocomplete="off" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label>Sub-titulo</label>
                                            <input type="text" class="form-control" name="sub_titulo" value="{{ old('sub_titulo') }}" placeholder="Sub-titulo" autocomplete="off">
                                            {{-- <textarea class="form-control" name="description" placeholder="Descrição" autocomplete="off" rows="6" required>{{ old('description') }}</textarea> --}}
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label>Limite de caracteres</label>
                                            <input type="text" class="form-control" name="limite_caractere" value="{{ old('limite_caractere') }}" placeholder="Digite o limite de caracteres" autocomplete="off" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label>Setor responsável</label>
                                            <select class="form-control select2" name="setor_id" required data-placeholder="Setor responsável pelo preenchimento">
                                                @foreach($teams as $setor)
                                                <option value="{{$setor->id}}">{{$setor->name}}</option>
                                                @endforeach
                                                {{-- <option value="1" {{(old('setor') == 1 ? "selected":"")}}>Recursos Humanos</option>
                                                <option value="0" {{(old('setor') == "0" ? "selected":"")}}>Departamento Pessoal</option> --}}
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12 d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary">Criar</button>
                                        <a class="btn btn-link pull-right"
                                           href="{{ route('forms.index') }}"><i
                                                class="bx bx-arrow-back"></i> Voltar</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="/bower_components/AdminLTE/plugins/select2/select2.full.min.js"></script>
    <script nonce="{{ csp_nonce() }}">
        $(function () {
            //Initialize Select2 Elements
            $(".select2").select2({
                allowClear: true,
            });
        });
    </script>

@endsection
