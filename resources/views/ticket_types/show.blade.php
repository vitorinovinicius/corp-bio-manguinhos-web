@extends('layouts.frest_template')

@section('content-header')
    <div class="content-header-left col-10 mb-2 mt-1">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h5 class="content-header-title float-left pr-1 mb-0">Tipo ticket / Exibir #{{$ticketType->id}}</h5>
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb p-0 mb-0">
                        <li class="breadcrumb-item"><i class="bx bx-home-alt"></i> Home</li>
                        <li class="breadcrumb-item">Tipo ticket</li>
                        <li class="breadcrumb-item active">Exibir</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="col-2 d-flex justify-content-end align-items-center">
        <form action="{{ route('ticket_types.destroy', $ticketType->uuid) }}" method="POST" style="display: inline;" onsubmit="if(confirm('Deseja realmente excluir esse item?')) { return true } else {return false };">
            <input type="hidden" name="_method" value="DELETE">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="btn-group pull-right" role="group" aria-label="...">
                @shield('groups.create')
                <a class="btn btn-success btn-group" role="group" href="{{ route('ticket_type_sections.create', $ticketType->uuid) }}" title="Adicionar Seção"><i class="bx bx-plus"></i> Adicionar Seção</a>
                @endshield
                @shield('groups.edit')
                    <a class="btn btn-warning btn-group" role="group" href="{{ route('ticket_types.edit', $ticketType->uuid) }}"><i class="bx bx-edit"></i> Editar</a>
                @endshield
                @shield('groups.destroy')
                    <button type="submit" class="btn btn-danger">Excluir <i class="bx bx-trash"></i></button>
                @endshield
            </div>
        </form>
    </div>
@endsection

@section('content')
    @include('messages')
    @include('error')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="box-title">Dados do tipo ticket</h3>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <form class="form form-vertical" action="" method="POST">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="name">ID</label>
                                        <p class="form-control-static" >{{$ticketType->id}}</p>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="name">Nome</label>
                                        <p class="form-control-static" >{{$ticketType->name}}</p>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="name">Descrição</label>
                                        <p class="form-control-static" >{{$ticketType->description}}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 d-flex justify-content-end">
                                    <a class="btn btn-link pull-right"
                                       href="{{ route('groups.show', $ticketType->group->uuid) }}"><i
                                            class="bx bx-arrow-back"></i> Voltar</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if($ticketType->ticketTypeSections->count())
        @foreach($ticketType->ticketTypeSections as $ticketTypeSection)
            <div id="{{$ticketTypeSection->id}}">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-7 grabbable">
                                        <h3 class="box-title">
                                            <i class="bx bx-move-vertical"></i>{{ $ticketTypeSection->name }}
                                        </h3>
                                    </div>
                                    <div class="col-5 d-flex justify-content-end align-items-center">
                                        @shield('groups.edit')
                                        <a class="btn btn-warning btn-group" role="group" href="{{ route('ticket_type_sections.edit', $ticketTypeSection->uuid)}}" title="Editar">Editar
                                            <i class="bx bx-edit"></i></a>
                                        @endshield

                                        @shield('groups.destroy')
                                        <form action="{{ route('ticket_type_sections.destroy', $ticketTypeSection->uuid) }}" method="POST" style="display: inline;" id="deleteForm">
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
                                            <div class="form-control-static">{!! nl2br($ticketTypeSection->description) !!}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    @if($ticketTypeSection->ticketTypeSectionFields->count())
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
                                                @foreach($ticketTypeSection->ticketTypeSectionFields as $form_field)
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
    @else
        <div class="alert alert-info" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Fechar">
                <span aria-hidden="true">&times;</span></button>
            <span class="bx bx-ok"></span><em> Você não tem nenhuma seção criada clique no botão acima (Adicionar Seção) para montar o seu formulário.</em>
        </div>
    @endif

@endsection
