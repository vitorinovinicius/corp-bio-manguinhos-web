@extends('layouts.frest_template')
@section('css')
    <!-- Select2 -->
    <link rel="stylesheet" href="/bower_components/AdminLTE/plugins/select2/select2.min.css">
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/css/pickers/pickadate/pickadate.css')}}">
@endsection

@section('content-header')
    <div class="content-header-left col-12 mb-2 mt-1">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h5 class="content-header-title float-left pr-1 mb-0">Produto / Criar</h5>
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb p-0 mb-0">
                        <li class="breadcrumb-item"><i class="bx bx-home-alt"></i> Home</li>
                        <li class="breadcrumb-item">Produto</li>
                        <li class="breadcrumb-item active">Criar</li>
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
                    <h3 class="box-title">Criar produto</h3>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <form class="form form-vertical" action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="name">Nome</label>
                                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" placeholder="Nome" >
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="description">Descrição</label>
                                            <input type="text" class="form-control" id="description" name="description" value="{{ old('description') }}" placeholder="Descrição" required>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="value">Valor</label>
                                            <input type="number" step="0.01" class="form-control" id="value" name="value" value="{{ old('value') }}" placeholder="Valor" required>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="amount">Quantidade</label>
                                            <input type="text" class="form-control" id="amount" name="amount" value="{{ old('amount') }}" placeholder="Quantidade" required>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="Validade">Status</label>
                                            <select class="form-control select2" name="status">
                                                <option value="1">Ativo</option>
                                                <option value="2">Inativo</option>
                                            </select>
                                        </div>
                                    </div>
                                    @if((Auth::user()->name) == "Superuser")
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="Validade">Empreiteira</label>
                                            <select class="form-control select2" name="contractor" id="contractor" placeholder="Selecione uma empreiteira">
                                                <option></option>
                                                @foreach($contractors as $contractor)
                                                    <option value="{{$contractor->id}}">{{$contractor->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    @endif

                                    <div class="col-12" id="categories">
                                        <div class="form-group">
                                            <label for="categories">Categorias</label>
                                        </div>
                                        @foreach ($categories as $category)
                                            <div class="col-4">
                                                <div class="form-check checkbox checkbox-primary">
                                                    <input class="form-check-input checkbox-input" type="checkbox" value="{{$category->id}}" id="categories_{{$category->id}}"  name="categories[]">
                                                    <label class="form-check-label" for="categories_{{$category->id}}">
                                                        {{$category->name}}
                                                    </label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-12 d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary">Criar</button>
                                        <a class="btn btn-link pull-right"
                                           href="{{ route('products.index') }}"><i
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

    <script src="{{asset('vendors/js/pickers/pickadate/picker.js')}}"></script>
    <script src="{{asset('vendors/js/pickers/pickadate/picker.date.js')}}"></script>
    <script nonce="{{ csp_nonce() }}">
        $('.date-picker').pickadate({
            formatSubmit: 'dd/mm/yyyy',
            monthsFull: [
                "Janeiro",
                "Fevereiro",
                "Março",
                "Abril",
                "Maio",
                "Junho",
                "Julho",
                "Agosto",
                "Setembro",
                "Outubro",
                "Novembro",
                "Dezembro"
            ],
            monthsShort: [
                "Jan",
                "Fev",
                "Mar",
                "Abr",
                "Ma",
                "Jun",
                "Jul",
                "Agos",
                "Set",
                "Out",
                "Nov",
                "Dez"
            ],
            weekdaysShort: [
                "D",
                "S",
                "T",
                "Q",
                "Q",
                "S",
                "S"
            ],
            today: 'Hoje',
            clear: 'Limpar',
            close: 'Fechar',
        });

        $(function () {
            //Initialize Select2 Elements
            $(".select2").select2({
                placeholder: "Selecione uma empreiteira",
                allowClear: true
            });

            $(".select").select2({
                placeholder: "Selecione status da categoria",
                allowClear: true
            });
        });

        $("#contractor").change(function(){
           var contractor = $(this).val();
           $.ajax({
               type:"GET",
               url: "{{route('categories.get.ajax')}}",
               data: {'contractor_id':contractor},
               success: function(data){
                    $("#categories").html("");
                    data.map(function(item){
                        $(
                            '<div class="col-4">'+
                                '<div class="form-check">'+
                                    '<input class="form-check-input" type="checkbox" name="categories[]" value="'+ item.id+'" >'+
                                    '<label class="form-check-label" for="defaultCheck1">'+
                                        item.name+
                                    '</label>'+
                                '</div>'+
                            '</div>'
                        ).appendTo("#categories")
                    });
               }
           })
        })
    </script>
@endsection
