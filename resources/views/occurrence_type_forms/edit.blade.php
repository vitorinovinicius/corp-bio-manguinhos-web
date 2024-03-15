@extends('layouts.adminlte')
@section('css')
    <!-- Select2 -->
    <link rel="stylesheet" href="/bower_components/AdminLTE/plugins/select2/select2.min.css">
@endsection
@section('header')
    <div class="page-header">
        <h3>Associação de formulário / Editar #{{$occurrence_type_form->id}}</h3>
    </div>
    <ol class="breadcrumb">
        <li><a href="/admin"><i class="bx bx-dashboard"></i> Home</a></li>
        <li> Associação de formulário</li>
        <li class="active">Editar</li>
    </ol>
@endsection

@section('content')
    @include('messages')
    @include('error')

    <div class="row">
        <div class="col-md-12">
            <div class="box box-danger">
                <form action="{{ route('occurrence_type_forms.update', $occurrence_type_form->uuid) }}" method="POST">
                    <div class="box-body padding-10">
                        <input type="hidden" name="_method" value="PUT">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">


                        <div class="form-group col-md-12" {{ $errors->has('occurrence_type_id') ? ' has-error' : '' }}>
                            <label for="occurrence_type_id">OS</label>
                            <div>
                                <select class="form-control select2" name="occurrence_type_id" required data-placeholder="Selecione uma OS" required>
                                    <option></option>
                                    @forelse($occurrence_types as $occurrence_type)
                                        <option value="{{$occurrence_type->id}}" {{($occurrence_type_form->occurrence_type_id == $occurrence_type->id) ?  "SELECTED" : "" }}>{{$occurrence_type->name}}</option>
                                    @empty
                                    @endforelse
                                </select>
                            </div>
                        </div>
                        <div class="form-group col-md-12" {{ $errors->has('form_id') ? ' has-error' : '' }}>
                            <label for="form_id">Formulário</label>
                            <div>
                                <select class="form-control select2" name="form_id" required data-placeholder="Selecione um formulário" required>
                                    <option></option>
                                    @forelse($forms as $form)
                                        <option value="{{$form->id}}" {{($occurrence_type_form->form_id == $form->id) ?  "SELECTED" : "" }}>{{$form->name}}</option>
                                    @empty
                                    @endforelse
                                </select>
                            </div>
                        </div>

                        <div class="form-group col-md-12 {{ $errors->has('is_required') ? ' has-error' : '' }}">
                            <label for="is_required">Obrigatório</label>
                            <div>
                                <input type="checkbox" class="cs_checkbox" name="is_required" value="1" {{($occurrence_type_form->is_required) ?  "checked" : "" }} >
                            </div>
                        </div>

                    </div>
                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary">Salvar</button>
                        <a class="btn btn-link pull-right" href="{{ route('occurrence_type_forms.index') }}"><i class="bx bx-arrow-back"></i>  Voltar</a>
                    </div>
                </form>
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
