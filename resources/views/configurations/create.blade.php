@extends('layouts.adminlte')
@section('css')
    <!-- Select2 -->
    <link rel="stylesheet" href="/bower_components/AdminLTE/plugins/select2/select2.min.css">
@endsection
@section('header')
    <div class="page-header">
        <h3> Configurações / Criar </h3>
    </div>
@endsection

@section('content')
    @include('messages')
    @include('error')

    <div class="row">
        <div class="col-md-12">
            <div class="box box-default">

                <form action="{{ route('configurations.store') }}" method="POST">
                    <div class="box-body">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        <div class="form-group  {{ $errors->has('contractor_id') ? ' has-error' : '' }}">
                            <label for="contractor_id">Empreireira</label>
                            <div>
                                <select class="form-control select2" id="contractor_id" name="contractor_id" data-placeholder="Empreiteira">
                                    <option></option>
                                    @forelse($contractors as $contractor)
                                        <option value="{{$contractor->id}}" {{((app('request')->input('contractor_id')==$contractor->id) ? "selected":"")}}>{{$contractor->name}}</option>
                                    @empty
                                    @endforelse
                                </select>
                            </div>
                        </div>

                        <div class="form-group  {{ $errors->has('config_key') ? ' has-error' : '' }}">
                            <label for="config_key">Chave</label>
                            <div>
                                <input type="text" class="form-control" name="config_key" value="{{ old('config_key') }}" placeholder="chave" autocomplete="off" required>
                            </div>
                        </div>

                        <div class="form-group  {{ $errors->has('config_value') ? ' has-error' : '' }}">
                            <label for="config_value">Valor</label>
                            <div>
                                <input type="text" class="form-control" name="config_value" value="{{ old('config_value') }}" placeholder="Valor" autocomplete="off" required>
                            </div>
                        </div>
                        <div class="form-group  {{ $errors->has('description') ? ' has-error' : '' }}">
                            <label for="description">Descrição</label>
                            <div>
                                <input type="text" class="form-control" name="description" value="{{ old('description') }}" placeholder="Descrição" autocomplete="off" required>
                            </div>
                        </div>
                        <div class="form-group  {{ $errors->has('tipo') ? ' has-error' : '' }}">
                            <label for="tipo">Tipo</label>
                            <div>
                                <select class="form-control select2" id="tipo" name="tipo" data-placeholder="Tipo">
                                    <option></option>
                                    <option value="1" {{((app('request')->input('tipo')==1) ? "selected":"")}}>Usuário</option>
                                    <option value="2" {{((app('request')->input('tipo')==2) ? "selected":"")}}>Sistema</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group  {{ $errors->has('tipo_user') ? ' has-error' : '' }}">
                            <label for="tipo_user">Tipo usuário</label>
                            <div>
                                <select class="form-control select2" id="tipo_user" name="tipo_user" data-placeholder="Tipo de usuário">
                                    <option></option>
                                    <option value="1" {{((app('request')->input('tipo_user')==1) ? "selected":"")}}>Empreiteira</option>
                                </select>
                            </div>
                        </div>

                    </div>
                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary">Criar</button>
                        <a class="btn btn-link pull-right" href="{{ route('configurations.index') }}"><i class="bx bx-arrow-back"></i> Voltar</a>
                    </div>
                </form>

            </div>
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
                allowClear: true,
                width: "100%"
            });
        });
    </script>
@endsection
