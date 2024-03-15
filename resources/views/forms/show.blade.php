@extends('layouts.frest_template')

@section('css')
    <!-- Select2 -->
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
    <div class="content-header-left col-7 mb-2 mt-1">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h5 class="content-header-title float-left pr-1 mb-0">Formulários / Exibir #{{$form->id}}</h5>
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb p-0 mb-0">
                        <li class="breadcrumb-item"><i class="bx bx-home-alt"></i> Home</li>
                        <li class="breadcrumb-item">Formulários</li>
                        <li class="breadcrumb-item active">Exibir</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="col-5 d-flex justify-content-end align-items-center">
        <form action="{{ route('forms.destroy', $form->uuid) }}" method="POST" style="display: inline;" onsubmit="if(confirm('Deseja realmente excluir esse item?')) { return true } else {return false };">
            <input type="hidden" name="_method" value="DELETE">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="btn-group pull-right" role="group" aria-label="...">

                @shield('form_section.create')
                <a class="btn btn-success btn-group" role="group" href="{{ route('form_sections.create', $form->uuid) }}" title="Adicionar Seção"><i class="bx bx-plus"></i> Adicionar Seção</a>
                @endshield

                @shield('form.edit')
                <a class="btn btn-warning btn-group" role="group" href="{{ route('forms.edit', $form->uuid) }}"><i class="bx bx-edit"></i> Editar</a>
                @endshield

                @shield('form.destroy')
                <button type="submit" class="btn btn-danger">Excluir <i class="bx bx-trash"></i></button>
                @endshield
            </div>
        </form>
    </div>
@endsection

@section('content')

    @if(Session::has('message_form'))
        <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Fechar">
                <span aria-hidden="true">&times;</span></button>
            <span class="bx bx-ok"></span><em> {!! session('message_form') !!}</em></div>
    @endif
    @if(Session::has('error_form'))
        <div class="alert alert-error alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Fechar" style="color: #FFF;">
                <span aria-hidden="true">&times;</span></button>
            <span class="bx bx-alert"></span><em>  {!! session('error_form') !!}</em></div>
    @endif

    @include("forms.include.show_form")

    @include('messages')
    @include('error')

    @if($form->form_sections->count())
        <div class="sortable">
            @foreach($form->form_sections()->orderBy("order","asc")->get() as $form_section)
                <div id="{{$form_section->id}}">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-7 grabbable">
                                            <h3 class="box-title">
                                                <i class="bx bx-move-vertical"></i>{{ $form_section->name }}
                                            </h3>
                                        </div>
                                        <div class="col-5 d-flex justify-content-end align-items-center">
                                            @shield('form_section.edit')
                                            <a class="btn btn-warning btn-group" role="group" href="{{ route('form_sections.edit', $form_section->uuid) }}" title="Editar">Editar
                                                <i class="bx bx-edit"></i></a>
                                            @endshield

                                            @shield('form_section.destroy')
                                            <form action="{{ route('form_sections.destroy', $form_section->uuid) }}" method="POST" style="display: inline;" id="deleteForm">
                                                <input type="hidden" name="_method" value="DELETE">
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                <button type="submit" class="btn btn-danger btn-group deleteForm" style="color: #FFFFFF">Excluir
                                                    <i class="bx bx-trash"></i></button>
                                            </form>
                                            @endshield
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="name">Descrição</label>
                                                <div class="form-control-static">{!! nl2br($form_section->description) !!}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        @if($form_section->form_fields->count())
                                            <div class="table-responsive">
                                                <table class="table table-condensed table-striped table-bordered table-sm table-hover th-center">
                                                    <thead>
                                                    <tr>
                                                        <th>Nome</th>
                                                        <th>Descrição</th>
                                                        <th>Tipo</th>
                                                        <th>Obrigatório</th>
                                                        <th>Min. fotos obrigatórias</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($form_section->form_fields as $form_field)
                                                        <tr>
                                                            <td class="font-medium-3" title="Nome">{{$form_field->name}}</td>
                                                            <td title="Descrição">{{$form_field->description}}</td>
                                                            <td title="Tipo"><span class="badge">{{$form_field->typeField()}}</span></td>
                                                            <td title="Obrigatório"><span class="badge badge-primary {{bagde_color($form_field->required)}}">{{$form_field->required()}}</span></td>
                                                            <td title="Mínimo de fotos obrigatórias">{{$form_field->min_photo}}</td>
                                                        </tr>
                                                        @if($form_field->type_field == 3 || $form_field->type_field == 1 || $form_field->type_field == 6)
                                                            @php
                                                                $lists =  array_filter(explode(";",$form_field->list));
                                                            @endphp

                                                            <tr>
                                                                <td colspan="5">
                                                                    <div style="padding: 0px 15px;">
                                                                        <b>Respostas:</b> <br>
                                                                        @foreach($lists as $list)
                                                                            <div class="row">
                                                                                <div class="col-12">
                                                                                    <div class="form-group">
                                                                                        <p class="form-control-static">{{$list}}</p>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        @endforeach
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        @endif
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="alert alert-info" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Fechar">
                <span aria-hidden="true">&times;</span></button>
            <span class="bx bx-ok"></span><em> Você não tem nenhuma seção criada clique no botão acima (Adicionar Seção) para montar o seu formulário.</em>
        </div>
    @endif

    <a class="btn btn-primary" href="{{ route('forms.index') }}"><i class="bx bx-arrow-back"></i> Voltar</a>
@endsection
@section('scripts')
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <!-- Jquery UI -->
    <script src="{{ url('../bower_components/jquery-ui/jquery-ui.min.js') }}"></script>

    <script nonce="{{ csp_nonce() }}">

        $(function () {
            $('.deleteForm').on('click', function (e) {
                e.preventDefault();

                let form = $(this).parent("form");

                swal({
                    title: "Tem certeza ?",
                    text: "Atenção ao excluir este item será excluída todas as seções e formulários vinculados a ele. Deseja realmente excluir esse item? ",
                    icon: "warning",
                    buttons: ["Cancelar", true],
                    dangerMode: true
                })
                    .then((willDelete) => {
                        if (willDelete) {
                            form.submit();
                        }

                        return false;
                    });
            });
        });


        function submitForm(id) {
            swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this imaginary file!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete) {
                        $("#deleteForm_" + id).submit();
                    }

                    return false;
                });

            return false;
        }

        $(function () {
            $(".sortable").sortable({
                handle: '.grabbable',
                update: function () {
                    var ordem_atual = $(this).sortable("toArray", "id");
                    console.log(ordem_atual);
                    $.ajax({
                        headers: {
                            'X-CSRF-Token': $('input[name="_token"]').val()
                        },
                        type: 'PUT',
                        url: '{{route("form_sections_order.order")}}',
                        data: {ordem_atual: ordem_atual},
                        success: function (data) {
                            //Ok
                        },
                        error: function () {
                            toastr.warning("Ocorreu um erro inesperado durante o processamento.\nRecarregue a página e tente novamente");
                        },
                    });

                }

            });
        });

    </script>

@endsection
