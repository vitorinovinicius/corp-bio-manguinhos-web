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
    <form class="form form-vertical" action="{{ route('ticket_form.store') }}" method="POST">
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
                                        <input type="text" class="form-control" id="user" name="user" value="{{ Auth::user()->name }}" readonly >
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Grupo</label>
                                        <select class="form-control select2 group_id" name="group_id" id="group_id"data-placeholder="Escolha um grupo">
                                            <option></option>
                                            @forelse($groups as $groups)
                                                <option
                                                    value="{{$groups->id}}" {{(old('occurrence_client_id')==$groups->id?"selected":"")}}>{{$groups->name}}</option>
                                            @empty
                                            @endforelse
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Tipo Ticket</label>
                                        <select class="form-control select2 ticket_type_id" name="ticket_type_id" id="ticket_type_id" data-placeholder="Escolha um ticket">                                            
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Cliente</label>
                                        <select class="form-control select2" name="occurrence_client_id" id="occurrence_client_id" data-placeholder="Escolha um cliente">                                            
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>                        
                    </div>
                </div>
            </div>
        </div>
    </div>
    
     <div class="row">
        <div class="col-12 d-flex justify-content-end">
            <button type="submit" class="btn btn-primary">Exibir Formulário</button>
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
