@extends('layouts.adminlte')
@section('css')
    <!-- DataTables -->
    <link rel="stylesheet" href="/js/datatables/dataTables.bootstrap.css">
    <link rel="stylesheet" href="/bower_components/AdminLTE/plugins/select2/select2.min.css">

@endsection
@section('header')
    <div class="page-header clearfix">
        <h3>
            Associação de formulário
            @shield('occurrence_type_forms.create')
            <a class="btn btn-success pull-right" href="{{ route('occurrence_type_forms.create') }}"><i class="bx bx-plus"></i> Criar</a>
            @endshield
        </h3>
    </div>
@endsection

@section('content')
    @include('messages')
    @include('error')
    {{--FILTROS INICIO--}}
    <div class="box box-danger clearfix {{app('request')->exists('occurrence_type_id') == false ? "collapsed-box" : ""}}">
        <div class="box-header with-border">
            <h3 class="box-title">Filtro</h3>

            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="bx bx-plus"></i>
                </button>
            </div>
        </div>
        <div class="box-body">
            <div class="row">
                <form method="get">
                    <div class="col-md-12">
                        <div class="form-group col-md-3">
                            <div>Ordem de Serviço</div>
                            <select class="form-control select2" name="occurrence_type_id" data-placeholder="Selecione o tipo da Ocorrência">
                                <option></option>
                                @foreach($occurrence_types as $ot)
                                    <option value="{{$ot->id}}" {{(app('request')->input('occurrence_type_id')==$ot->id?"selected":"")}}>{{$ot->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <div>Formulário</div>
                            <select class="form-control select2" name="form_id" data-placeholder="Selecione o formulário">
                                <option></option>
                                @foreach($forms as $form)
                                    <option value="{{$form->id}}" {{(app('request')->input('form_id')==$form->id?"selected":"")}}>{{$form->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12 clearfix">
                        <div class="pull-right">
                            <a href="/{{Route::getCurrentRoute()->uri()}}" class="btn btn-default">Limpar</a>
                            <button type="submit" class="btn btn-primary " id="btn-external-filter">Aplicar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{--FILTROS FIM--}}

    <div class="row">
        <div class="col-md-12">
            <div class="box box-danger">
                <div class="box-body">
                    @if($occurrence_type_forms->count())
                        <table class="table table-condensed table-striped table-sm table-hover">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>OS</th>
                                <th>Formulário</th>
                                <th>Obrigatório</th>

                                <th class="text-right">OPÇÕES</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach($occurrence_type_forms as $occurrence_type_form)
                                <tr>
                                    <td>{{$occurrence_type_form->id}}</td>
                                    <td>{{optional($occurrence_type_form->occurrence_type)->name}}</td>
                                    <td>{{optional($occurrence_type_form->form)->name}}</td>
                                    <td>{{sim_nao($occurrence_type_form->is_required)}}</td>
                                    <td class="text-right">
                                        @shield('occurrence_type_form.show')
                                        <a class="btn btn-xs btn-primary" href="{{ route('occurrence_type_forms.show', $occurrence_type_form->uuid) }}"><i class="bx bx-eye-open"></i> Exibir</a>
                                        @endshield
                                        @shield('occurrence_type_form.edit')
                                        <a class="btn btn-xs btn-warning" href="{{ route('occurrence_type_forms.edit', $occurrence_type_form->uuid) }}"><i class="bx bx-edit"></i> Editar</a>
                                        @endshield
                                        @shield('occurrence_type_form.destroy')
                                        <form action="{{ route('occurrence_type_forms.destroy', $occurrence_type_form->uuid) }}" method="POST" style="display: inline;" onsubmit="if(confirm('Deseja realmente excluir esse item?')) { return true } else {return false };">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <button type="submit" class="btn btn-xs btn-danger">
                                                <i class="bx bx-trash"></i> Excluir
                                            </button>
                                        </form>
                                        @endshield
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {!! $occurrence_type_forms->render() !!}
                    @else
                        <h3 class="text-center alert alert-info">Vazio!</h3>
                    @endif
                </div>
            </div>
        </div>
    </div>

@endsection
@section('scripts2')
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
