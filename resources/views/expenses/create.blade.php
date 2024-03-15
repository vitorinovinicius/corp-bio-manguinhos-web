@extends('layouts.frest_template')
@section('css')
    <!-- Select2 -->
    <link rel="stylesheet" href="/bower_components/AdminLTE/plugins/select2/select2.min.css">
@endsection

@section('content-header')
    <div class="content-header-left col-12 mb-2 mt-1">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h5 class="content-header-title float-left pr-1 mb-0">Despesa / Criar</h5>
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb p-0 mb-0">
                        <li class="breadcrumb-item"><i class="bx bx-home-alt"></i> Home</li>
                        <li class="breadcrumb-item">Despesa</li>
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
    <form action="{{route('expense.store')}}" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="box-title">Lançamento de despesas por técnico</h3>
                        <div>Busca as OSs do técnico do último mês para lançamento</div>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Técnico</label>
                                        <select name="user_id" id="user_id" class="form-control select2" data-placeholder="Técnico">
                                            <option value=""></option>
                                            @foreach ($operators as $operator)
                                                <option value="{{$operator->id}}" data-uuid="{{$operator->uuid}}" {{(app('request')->input('user_id')==$operator->id?"selected":"")}}>{{$operator->name}}</option>

                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4><i class="bx bx-list-plus"></i>Adicionar despesas</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-2">
                                    <div class="form-group">
                                        <label for="">Despesa</label>
                                        <select name="" id="expenseType" class="form-control select2"  data-placeholder="Despesa">
                                            <option value=""></option>
                                            @foreach (\App\Models\ExpenseTypes::all() as $expense)
                                                <option value="{{$expense->id}}">{{$expense->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="form-group">
                                        <label for="">OS</label>
                                        <select name="" id="occurrenceId" class="form-control select2"  data-placeholder="OS">
                                            <option value=""></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="form-group">
                                        <label for="">Valor</label>
                                        <input type="number" step="0.01" name="" id="value" class="form-control" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="form-group">
                                        <label for="">Data</label>
                                        <input type="date" name="" id="date" class="form-control" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="form-group">
                                        <label for="">Comentário</label>
                                        <input type="text" name="" id="comment" class="form-control" autocomplete="off">
                                    </div>
                                </div>
                                {{-- <div class="col-2">
                                    <div class="form-group">
                                        <div class="custom-file">
                                            <label for="">Comprovante</label>
                                            <input type="file" name="" id="receipt" >
                                        </div>
                                    </div>
                                </div> --}}
                                <div class="col-2">
                                    <div class="form-group">
                                        <br>
                                        <button style="white-space: inherit" class="btn btn-success" id="addItem" title="Adicionar">
                                            <i class="bx bx-plus"></i> Adicionar
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4><i class="bx bx-list-ul"></i>Lista de despesas </h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <div id="listItens">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 d-flex justify-content-end">
                <button type="submit" class="btn btn-primary">Criar</button>
                {{-- <a class="btn btn-link pull-right"
                   href="{{ route('forms.show', $form->uuid) }}"><i
                        class="bx bx-arrow-back"></i> Voltar</a> --}}
            </div>
        </div>
    </form>
@endsection
@section('scripts')
    <!-- Select2 -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="/bower_components/AdminLTE/plugins/select2/select2.full.min.js"></script>
    <script nonce="{{ csp_nonce() }}">
        $('#addItem').click(function (event) {

            event.preventDefault();

            let expenseType = $('#expenseType').val();
            let expenseTypeText = $('#expenseType option:selected').text();
            let occurrenceId = $('#occurrenceId').val();
            let value = $('#value').val();
            let comment = $('#comment').val();
            let date = $('#date').val();

            if (value == "") {
                swal("Atenção!", "Preencha o campo.", "error");
                return false;
            }

            var item = "<div class='row'>"
                +
                "<div class='col-2'><div class='form-group'>"
                +
                "<label>Despesa</label><input type='text' class='form-control' name='' value='" + expenseTypeText + "' readonly><input type='hidden' class='form-control' name='expense_types_id[]' value='" + expenseType + "' readonly>"
                +
                "</div></div>"
                +
                "<div class='col-2'><div class='form-group'>"
                +
                "<label>OS</label><input type='text' class='form-control' name='occurrence_id[]' value='" + occurrenceId + "' readonly>"
                +
                "</div></div>"
                +
                "<div class='col-2'><div class='form-group'>"
                +
                "<label>Valor</label><input type='number' step='0.01' class='form-control' name='value[]' value='" + value + "' readonly>"
                +
                "</div></div>"
                +
                "<div class='col-2'><div class='form-group'>"
                +
                "<label>Data</label><input type='date' class='form-control' name='date[]' value='" + date + "' readonly>"
                +
                "</div></div>"
                +
                "<div class='col-2'><div class='form-group'>"
                +
                "<label>Comentário</label><input type='text' class='form-control' name='comment[]' value='" + comment + "' readonly>"
                +
                "</div></div>"
                +
                "<div class='col-2'><div class='form-group'>"
                +
                "<label>Comprovante</label><input type='file' class='form-control' name='photo_voucher[]' multiple>"
                +
                "</div></div>"
                +
                "</div>";

            $("#listItens").append(item);

            $('#expenseType').val('');
            $('#occurrenceId').val('');
            $('#value').val('');
            $('#comment').val('');
            $('#date').val('');

        });

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
                        option += '<option></option>';
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
