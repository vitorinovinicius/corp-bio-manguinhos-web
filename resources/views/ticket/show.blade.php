@extends('layouts.frest_template')

@section('content-header')
    <div class="content-header-left col-8 mb-2 mt-1">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h5 class="content-header-title float-left pr-1 mb-0">Ticket / Exibir #{{$ticket->id}}</h5>
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb p-0 mb-0">
                        <li class="breadcrumb-item"><i class="bx bx-home-alt"></i> Home</li>
                        <li class="breadcrumb-item">Ticket</li>
                        <li class="breadcrumb-item active">Exibir</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="col-4 d-flex justify-content-end align-items-center">
        <form action="{{ route('ticket.destroy', $ticket->id) }}" method="POST" style="display: inline;" onsubmit="if(confirm('Deseja realmente excluir esse item?')) { return true } else {return false };">
            <input type="hidden" name="_method" value="DELETE">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="btn-group pull-right" role="group" aria-label="...">
                @shield('occurrence.create')
                    @if($ticket->status == 1)
                        <a class="btn btn-primary btn-group" role="group" href="{{ route('ticket.create_os', $ticket->uuid) }}"><i class="bx bx-edit"></i> Criar OS</a>
                        <a class="btn btn-warning btn-group" role="group" href="{{ route('ticket.cancel', $ticket->uuid) }}"><i class="bx bx-edit"></i> Cancelar</a>
                    @endif
                @endshield
                {{-- <a class="btn btn-warning btn-group" role="group" href="{{ route('ticket.edit', $ticket->id) }}"><i class="bx bx-edit"></i> Editar</a>
                <button type="submit" class="btn btn-danger">Excluir <i class="bx bx-trash"></i></button> --}}
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
                    <h3 class="box-title">Dados do ticket</h3>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <form class="form form-vertical" action="#" method="POST">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="ticket_id" value="{{ $ticket->id }}">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="name">ID</label>
                                        <p class="form-control-static" >{{$ticket->id}}</p>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="name">Usuário</label>
                                        <p class="form-control-static" >{{$ticket->user->name}}</p>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="name">Cliente</label>
                                        <p class="form-control-static" >{{$ticket->occurrence_client->name}}</p>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="name">Descrição</label>
                                        <p class="form-control-static" >{{$ticket->description}}</p>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="name">Justificativa</label>
                                        <p class="form-control-static" >{{$ticket->justification}}</p>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="name">Status</label>
                                        <p class="form-control-static" >{{$ticket->getStatus($ticket->status)}}</p>
                                    </div>
                                </div>
                            </div>                            
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
   
    @if($dataForms && $dataForms != '')       
   
        <div class="row">
            <div class="col-12">
                @foreach ($dataForms as $formSections)
                    <div class="card">
                        <div class="card-header">
                            <h3 class="box-title">{{$formSections["name"] }}</h3>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <div class="row">
                                    @if(isset($formSections["form_fields"]))
                                        @foreach($formSections["form_fields"] as $field)
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label><strong>{{$field["name"] }}</strong></label>
                                                    <p>{!! $field["description"] !!}</p>
                                                    @if (($field['type_field'] == 1 || $field['type_field'] == 3 || $field['type_field'] == 6) && isset($field['value']))
                                                        @php
                                                            $values[] = $field['value'];
                                                            $list = array_filter(explode(';',$field['list']));                                                            
                                                        @endphp
                                                        @foreach($list as $value)
                                                           
                                                            @if(in_array($value, $values))
                                                                <div class="form-control input-static">
                                                                    {{$value}}
                                                                </div>
                                                            @endif
                                                        @endforeach
                                                    @elseif($field['type_field'] == 5 || $field['type_field'] == 7)
                                                        
                                                        @if(isset($field["value"]) && !empty($field["value"]))
                                                            <div class="row">
                                                                <div class="col-2 text-center">
                                                                    <img src="{{$field["value"]}}"
                                                                         style="display: block; max-width: 100%; height:auto;"
                                                                         class="img-responsive cursor-pointer open-modal-img"
                                                                         id="image-rotate-{{$field["value"]}}" data-toggle="modal" data-target="#imgModal"
                                                                         data-image="{{$field["value"]}}">
                                                                    <div class="hidden-pdf">
                                                                        <a href="{{$field["value"]}}" class="btn btn-link" target="_blank">
                                                                            Abrir externamente
                                                                            <i class="bx bx-share"></i>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    @else
                                                        <div class="form-control input-static">
                                                            {{ (isset($field["value"])) ? $field["value"] : ""}}
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif                                    
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>        
    @endif
    <div class="row">
        <div class="col-12 d-flex justify-content-end">
            @is('admin')
                {{-- <button type="submit" class="btn btn-primary">Criar OS </button> --}}
                <a class="btn btn-link pull-right"
                   href="{{ route('ticket.index') }}"><i
                        class="bx bx-arrow-back"></i> Voltar</a>
            @endis
        </div>
    </div>    

@endsection
