@extends('layouts.frest_template')
@section('css')
    <!-- Select2 -->
    <link rel="stylesheet" href="/bower_components/AdminLTE/plugins/select2/select2.min.css">
@endsection

@section('content-header')
    <div class="content-header-left col-12 mb-2 mt-1">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h5 class="content-header-title float-left pr-1 mb-0">Ticket / Criar</h5>
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb p-0 mb-0">
                        <li class="breadcrumb-item"><i class="bx bx-home-alt"></i> Home</li>
                        <li class="breadcrumb-item">Ticket</li>
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
    <form class="form form-vertical" action="{{ route('ticket.store') }}" method="POST" enctype="multipart/form-data">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="box-title">Criar Ticket</h3>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="form-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="name">Usuário</label>
                                        <input type="hidden" class="form-control" id="user_id" name="user_id" value="{{ Auth::user()->id }}">
                                        <input type="text" class="form-control" id="user" name="user" value="{{ Auth::user()->name }}" readonly >
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Grupo</label>
                                        <input type="hidden" class="form-control" id="group_id" name="group_id" value="{{ $group->id }}">
                                        <input type="text" class="form-control" id="group-name" value="{{ $group->name }}" readonly >
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Tipo Ticket</label>
                                        <input type="hidden" class="form-control" id="ticket_type_id" name="ticket_type_id" value="{{ $ticketType->id }}">
                                        <input type="text" class="form-control" id="ticket-type" name="ticket-type" value="{{ $ticketType->name }}" readonly >
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Cliente</label>
                                        <input type="hidden" class="form-control" id="occurrence_client_id" name="occurrence_client_id" value="{{ $occurrenceClient->id }}">
                                        <input type="text" class="form-control" id="occurrence-client" name="occurrence-client" value="{{ $occurrenceClient->name }}" readonly >
                                    </div>
                                </div>
                            </div>
                        </div>                        
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if(isset($ticketType->ticketTypeSections) && $ticketType->ticketTypeSections->count() > 0)
        @php $i = 0 @endphp
        <input type="hidden" name="form[{{$i}}][contractor_id]" value="{{$ticketType->contractor_id}}">
        <input type="hidden" name="form[{{$i}}][id]" value="{{$ticketType->id}}">
        <input type="hidden" name="form[{{$i}}][name]" value="{{$ticketType->name}}">
        <input type="hidden" name="form[{{$i}}][description]" value="{{$ticketType->description}}">
        <input type="hidden" name="form[{{$i}}][uuid]" value="{{$ticketType->uuid}}">        
        <div class="card">
            <div class="card-header">
                <h3 class="box-title">{{$ticketType->name }}</h3>
            </div>
            <div class="card-content">
                <div class="card-body box-body">
                    @php $s = 0 @endphp
                    @foreach($ticketType->ticketTypeSections as $ticketTypeSection)
                        <input type="hidden" name="form[{{$i}}][sections][{{$s}}][contractor_id]" value="{{$ticketTypeSection->contractor_id}}">
                        <input type="hidden" name="form[{{$i}}][sections][{{$s}}][ticket_type_id]" value="{{$ticketTypeSection->ticket_type_id}}">
                        <input type="hidden" name="form[{{$i}}][sections][{{$s}}][id]" value="{{$ticketTypeSection->id}}">
                        <input type="hidden" name="form[{{$i}}][sections][{{$s}}][name]" value="{{$ticketTypeSection->name}}">
                        <input type="hidden" name="form[{{$i}}][sections][{{$s}}][description]" value="{{$ticketTypeSection->description}}">
                        <input type="hidden" name="form[{{$i}}][sections][{{$s}}][uuid]" value="{{$ticketTypeSection->uuid}}">
                        <input type="hidden" name="form[{{$i}}][sections][{{$s}}][updated_at]" value="{{$ticketTypeSection->updated_at}}">
                        <input type="hidden" name="form[{{$i}}][sections][{{$s}}][created_at]" value="{{$ticketTypeSection->created_at}}">  
                        
                        <div class="card border">
                            <div class="card-header">
                                <h3 class="box-title">{{$ticketTypeSection->name }}</h3>
                            </div>
                            <div class="card-content">
                                <div class="card-body box-body">
                                    @php $f = 0 @endphp
                                    @foreach($ticketTypeSection->ticketTypeSectionFields as $field)
                                    <input type="hidden" name="form[{{$i}}][sections][{{$s}}][form_fields][{{$f}}][form_section_id]" value="{{$field->form_section_id}}">
                                        <input type="hidden" name="form[{{$i}}][sections][{{$s}}][form_fields][{{$f}}][is_photo]" value="{{$field->is_photo}}">
                                        <input type="hidden" name="form[{{$i}}][sections][{{$s}}][form_fields][{{$f}}][code]" value="{{$field->code}}">
                                        <input type="hidden" name="form[{{$i}}][sections][{{$s}}][form_fields][{{$f}}][min_photo]" value="{{$field->min_photo}}">
                                        <input type="hidden" name="form[{{$i}}][sections][{{$s}}][form_fields][{{$f}}][description]" value="{{$field->description}}">
                                        <input type="hidden" name="form[{{$i}}][sections][{{$s}}][form_fields][{{$f}}][required_photo]" value="{{$field->required_photo}}">
                                        <input type="hidden" name="form[{{$i}}][sections][{{$s}}][form_fields][{{$f}}][created_at]" value="{{$field->created_at}}">
                                        <input type="hidden" name="form[{{$i}}][sections][{{$s}}][form_fields][{{$f}}][list]" value="{{$field->list}}">
                                        <input type="hidden" name="form[{{$i}}][sections][{{$s}}][form_fields][{{$f}}][uuid]" value="{{$field->uuid}}">
                                        <input type="hidden" name="form[{{$i}}][sections][{{$s}}][form_fields][{{$f}}][deleted_at]" value="{{$field->deleted_at}}">
                                        <input type="hidden" name="form[{{$i}}][sections][{{$s}}][form_fields][{{$f}}][required]" value="{{$field->required}}">
                                        <input type="hidden" name="form[{{$i}}][sections][{{$s}}][form_fields][{{$f}}][contractor_id]" value="{{$field->contractor_id}}">
                                        <input type="hidden" name="form[{{$i}}][sections][{{$s}}][form_fields][{{$f}}][updated_at]" value="{{$field->updated_at}}">
                                        <input type="hidden" name="form[{{$i}}][sections][{{$s}}][form_fields][{{$f}}][type_field]" value="{{$field->type_field}}">
                                        <input type="hidden" name="form[{{$i}}][sections][{{$s}}][form_fields][{{$f}}][name]" value="{{$field->name}}">
                                        <input type="hidden" name="form[{{$i}}][sections][{{$s}}][form_fields][{{$f}}][id]" value="{{$field->id}}">
                                        <input type="hidden" name="form[{{$i}}][sections][{{$s}}][form_fields][{{$f}}][item_inspection]" value="{{$field->item_inspection}}">
                                        <input type="hidden" name="form[{{$i}}][sections][{{$s}}][form_fields][{{$f}}][acceptance_criteria]" value="{{$field->acceptance_criteria}}">
                                        <input type="hidden" name="form[{{$i}}][sections][{{$s}}][form_fields][{{$f}}][status]" value="{{$field->status}}">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <div>
                                                        <label class="cs-label">{{$field->name }}</label>
                                                        <p>{!! $field->description !!}</p>
                                                    </div>
                                                </div>
                                                <div class="">
                                                    @if ($field->type_field == 1 || $field->type_field == 3 || $field->type_field == 6)
                                                            @php
                                                                $values = array_filter(explode(';',$field->value));
                                                                $list = array_filter(explode(';',$field->list));
                                                            @endphp
                                                        @endif

                                                        @switch($field->type_field)

                                                            @case(1)
                                                            @foreach($list as $value)
                                                                <div class="form-control">
                                                                    <input type="checkbox"
                                                                           id="{{$value}}"
                                                                           {{-- name="{{$value}}" --}}
                                                                           name="form[{{$i}}][sections][{{$s}}][form_fields][{{$f}}][value][]"
                                                                           value="{{$value}}"
                                                                           @if (in_array($value, $values))
                                                                           checked
                                                                        @endif
                                                                        {{--                                                        {{$field->required == 1 ? " required" : ""}}--}}
                                                                    >
                                                                    <label for="">{{$value}}</label>
                                                                </div>
                                                            @endforeach
                                                            @break

                                                            @case("2")
                                                            <input type="text" class="form-control" name="form[{{$i}}][sections][{{$s}}][form_fields][{{$f}}][value]" placeholder="Sua resposta">
                                                            @break

                                                            @case(3)
                                                            @foreach($list as $value)
                                                                <div class="form-control">
                                                                    <input type="radio"
                                                                           id="{{$value}}"
                                                                           {{-- name="{{$field->name}}" --}}
                                                                           name="form[{{$i}}][sections][{{$s}}][form_fields][{{$f}}][value]"
                                                                           value="{{$value}}"
                                                                           @if (in_array($value, $values))
                                                                           checked
                                                                        @endif
                                                                        {{$field->required == 1 ? " required" : ""}}
                                                                    >
                                                                    <label for="">{{$value}}</label>
                                                                </div>
                                                            @endforeach
                                                            @break

                                                            @case(4)
                                                            <input type="number" class="form-control" name="form[{{$i}}][sections][{{$s}}][form_fields][{{$f}}][value]">
                                                            @break

                                                            @case(5)
                                                            <input type="file" class="form-control" name="form[{{$i}}][sections][{{$s}}][form_fields][{{$f}}][value]">
                                                            @break

                                                            @case(6)
                                                            <select name="form[{{$i}}][sections][{{$s}}][form_fields][{{$f}}][value]" class="form-control" {{$field->required == 1 ? " required" : ""}}>
                                                                <option value=""></option>
                                                                @foreach($list as $value)
                                                                    <option value="{{$value}}">{{$value}}</option>

                                                                    @if (in_array($value, $values))
                                                                        selected
                                                                    @endif
                                                                @endforeach
                                                            </select>
                                                            @break

                                                            @case(7)
                                                            <input type="file" class="form-control" name="form[{{$i}}][sections][{{$s}}][form_fields][{{$f}}][value]">
                                                            @break
                                                        @endswitch
                                                </div>
                                            </div>
                                            @php $f++ @endphp
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        @php $s++ @endphp
                    @endforeach
                    @php $i++ @endphp
                </div>
            </div>
        </div>
    @endif
     <div class="row">
        <div class="col-12 d-flex justify-content-end">
            <button type="submit" class="btn btn-primary">Salvar</button>
            <a class="btn btn-link pull-right"
                href="{{ URL::previous() }}"><i
                    class="bx bx-arrow-back"></i> Voltar</a>
        </div>
    </div>
</form>
@endsection
@section('scripts')
    <!-- Select2 -->
    <script src="/bower_components/AdminLTE/plugins/select2/select2.full.min.js"></script>
    <script nonce="{{ csp_nonce() }}">
        $(function () {
            //Initialize Select2 Elements
            $(".select2").select2({
                placeholder: "Selecione um supervisor",
                allowClear: true
            });

            var $group_id = $(".group_id");

            $group_id.on("select2:select", function (e) {
                var oc_id = $(this).val();
                jQuery.ajax({
                    type: 'GET',
                    url: '/admin/ticket_type/type_ajax/' + oc_id,
                    success: function (data) {
                        if (data == "") {
                            alert("Dados do ticket não encontrados");
                        } else {
                            data.forEach(element => {
                                $("#ticket_type_id").append('<option value="'+ element.id +'">'+ element.name +'</option>')
                            });
                        }
                    }
                });
            });

            var $group_id = $(".group_id");

            $group_id.on("select2:select", function (e) {
                var oc_id = $(this).val();
                jQuery.ajax({
                    type: 'GET',
                    url: '/admin/occurrence_clients/by_group_ajax/' + oc_id,
                    success: function (data) {
                        if (data == "") {
                            alert("Dados do cliente não encontrados");
                        } else {
                            data.forEach(element => {
                                $("#occurrence_client_id").append('<option value="'+ element.id +'">'+ element.name +'</option>')
                            });
                        }
                    }
                });

            });
            
        });
    </script>
@endsection
