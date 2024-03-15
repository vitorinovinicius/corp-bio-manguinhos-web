@extends('layouts.frest_template')
@section('css')
    <!-- Select2 -->
    <link rel="stylesheet" href="/bower_components/AdminLTE/plugins/select2/select2.min.css">
@endsection

@section('content-header')
    <div class="content-header-left col-12 mb-2 mt-1">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h5 class="content-header-title float-left pr-1 mb-0">Despesa / Editar #{{$expense->id}}</h5>
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb p-0 mb-0">
                        <li class="breadcrumb-item"><i class="bx bx-home-alt"></i> Home</li>
                        <li class="breadcrumb-item">Dispesa</li>
                        <li class="breadcrumb-item active">Editar</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="box-title">Editar despesa</h3>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <form class="form form-vertical" action="{{ route('expense.update', $expense->uuid) }}" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="_method" value="PUT">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label>Técnico</label>
                                            <select name="user_id" id="user_id" class="form-control select2" data-placeholder="Técnico">
                                                <option value=""></option>
                                                @foreach ($operators as $operator)
                                                    <option value="{{$operator->id}}" @if($expense->user_id == $operator->id) selected @endif data-uuid="{{$operator->uuid}}" {{(app('request')->input('user_id')==$operator->id?"selected":"")}}>{{$operator->name}}</option>

                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label>OS</label>
                                            <select name="" id="occurrenceId" class="form-control select2"  data-placeholder="OS">
                                                <option value=""></option>
                                                @if($expense->occurrence_id)<option value="{{$expense->occurrence_id}}" selected>{{$expense->occurrence_id}}</option>@endif
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-4">
                                        <div class="form-group">
                                            <label>Tipo de despesa</label>
                                            <select name="" id="expenseType" class="form-control select2"  data-placeholder="Tipo de Despesa">
                                                <option value=""></option>
                                                @foreach (\App\Models\ExpenseTypes::all() as $type)
                                                    <option value="{{$type->id}}" @if($expense->expense_types_id == $type->id) selected @endif >{{$type->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label>Categoria</label>
                                            <select name="" id="category" class="form-control select2"  data-placeholder="Categoria">
                                                <option value=""></option>
                                                <option value="1" @if($expense->category == 1) selected @endif >Avulso</option>
                                                <option value="2" @if($expense->category == 2) selected @endif>KM</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label>Valor</label>
                                            <input type="text" class="form-control" name="value" value="{{number_format((float)$expense->value, 2, ',', '.')}}">
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label>Comentário</label>
                                            <input type="text" class="form-control" name="comment" value="{{$expense->comment}}">
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label>Status</label>
                                            <select name="status" class="form-control select2"  data-placeholder="Status">
                                                <option value=""></option>
                                                <option value="2" @if($expense->status == 2) selected @endif>Paga</option>
                                                <option value="1" @if($expense->status == 1) selected @endif>Pendente</option>
                                                <option value="3" @if($expense->status == 3) selected @endif>Recusada</option>
                                                <option value="4" @if($expense->status == 4) selected @endif>Inválida</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary">Salvar</button>
                                        <a class="btn btn-link pull-right"
                                           href="{{ route('expense.index') }}"><i
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
    <!-- Select2 -->
    <script src="/bower_components/AdminLTE/plugins/select2/select2.full.min.js"></script>
    <!-- Datepicker -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.0/js/bootstrap-datepicker.min.js"></script>
    <script nonce="{{ csp_nonce() }}">

        $(document).ready(function () {
            var id = '';
            id = $("#contractor option:selected").val();
            ajax(id);
        });

        $('#contractor').change(function () {
            id = $(this).val();
            ajax(id);
        })

        function ajax(id) {
            $.ajax({
                type: "GET",
                url: '/admin/operators/ajax/' + id,
                success: function (data) {
                    console.log(data);
                    var option = '';
                    $.each(data, function (i, obj) {
                        option += '<option value="' + obj.id + '">' + obj.name + '</option>';
                    });
                    $('#users').html(option).show();
                    console.log(option);
                },
                error: function () {
                    console.log('merge')
                }
            })
        }


        $(function () {
            //Initialize Select2 Elements
            $(".select2").select2({
                allowClear: true,
                width: "100%"
            });

            $('#user_id').on('select2:select', function (e) {
                var data = e.params.data;
                var uuid = data.element.dataset.uuid;

                $.ajax({
                    type: "GET",
                    url: '/admin/occurrences/operators/ajax/' + uuid,
                    success: function (data) {
                        // console.log(data);
                        var option = '';
                        option += '<option value=""></option>';
                        $.each(data, function (i, obj) {
                            option += '<option value="' + obj.id + '">' + obj.id + '</option>';
                        });
                        $('#occurrenceId').html(option).show();
                        // console.log(option);
                    },
                    error: function () {
                        console.log('merge')
                    }
                })
            });
        });


    </script>

@endsection
