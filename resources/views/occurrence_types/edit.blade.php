@extends('layouts.frest_template')
@section('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.0/css/bootstrap-datepicker.css" rel="stylesheet">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <style nonce="{{ csp_nonce() }}">
        .grabbable {
            cursor: grab;
        }

        .grabbable:active {
            cursor: grabbing;
        }
    </style>
@endsection
@section('content-header')
    <div class="content-header-left col-12 mb-2 mt-1">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h5 class="content-header-title float-left pr-1 mb-0">Tipos de Ocorrência / Editar #{{$occurrence_type->id}}</h5>
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb p-0 mb-0">
                        <li class="breadcrumb-item"><i class="bx bx-home-alt"></i> Home</li>
                        <li class="breadcrumb-item">Tipos de Ocorrência</li>
                        <li class="breadcrumb-item active">Editar</li>
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
                    <h3 class="box-title">Editar tipo de occorrência</h3>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <form class="form form-vertical" action="{{ route('occurrence_types.update', $occurrence_type->uuid) }}" method="POST">
                            <input type="hidden" name="_method" value="PUT">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label>Nome</label>
                                            <input type="text" class="form-control" id="name" value="{{ (old('name'))? old('name') : $occurrence_type->name}}" name="name" placeholder="Nome">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label>Descrição</label>
                                            <input type="text" class="form-control" id="description" value="{{ (old('description'))? old('description') : $occurrence_type->description}}" name="description" placeholder="Descrição">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label>Tempo médio de execução</label>
                                            <input type="time" class="form-control" id="average_time" value="{{ (old('average_time'))? old('average_time') : $occurrence_type->average_time}}" name="average_time" placeholder="Tempo médio de execução">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label>Status</label>
                                            <select class="form-control select2" name="status" data-placeholder="Selecione um status" required>
                                                <option value="1" {{($occurrence_type->status == 1) ?  "SELECTED" : "" }}>Ativo</option>
                                                <option value="0" {{($occurrence_type->status == 0) ?  "SELECTED" : "" }}>Inativo</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card">
                                            <div class="card-header">
                                                <h3 class="box-title">Formulários</h3>
                                            </div>
                                            <div class="card-content">
                                                <div class="card-body">
                                                    <div class="row sortable">
                                                        @foreach($forms as $form)
                                                            <div class="col-12 mb-1">
                                                                <i class="bx bx-move-vertical grabbable"></i>
                                                                <div class="checkbox">
                                                                    {{ Form::checkbox('form_id[]', $form->id, in_array($form->id, $selectedForms),["id"=>"form_".$form->id,'class' => 'checkbox-input']) }}
                                                                    {{ Form::label('form_' . $form->id, ucfirst($form->name)) }}
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12 d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary">Salvar</button>
                                        <a class="btn btn-link pull-right"
                                           href="{{ route('occurrence_types.index') }}"><i
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.0/js/bootstrap-datepicker.min.js"></script>
    <!-- Jquery UI -->
    <script src="{{ url('../bower_components/jquery-ui/jquery-ui.min.js') }}"></script>
    <script nonce="{{ csp_nonce() }}">
        $('.date-picker').datepicker({});
        $(".sortable").sortable();

    </script>
@endsection
