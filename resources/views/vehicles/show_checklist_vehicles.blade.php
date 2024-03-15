@extends('layouts.frest_template')
@section('css')
    <link rel="stylesheet" href="/bower_components/AdminLTE/plugins/select2/select2.min.css">
@endsection
@section('header')
    <div class="page-header clearfix">
        <h2>
            Checklist de Veículos
        </h2>
    </div>
@endsection

@section('content-header')
    <div class="content-header-left col-10 mb-2 mt-1">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h5 class="content-header-title float-left pr-1 mb-0">Checklist de Veículos / Exibir #{{$vehicleChecklistBasic->id}}</h5>
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb p-0 mb-0">
                        <li class="breadcrumb-item"><i class="bx bx-home-alt"></i> Home</li>
                        <li class="breadcrumb-item">Checklist de Veículos</li>
                        <li class="breadcrumb-item active">Exibir</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="col-2 d-flex justify-content-end align-items-center">
        <div class="btn-group pull-right" role="group" aria-label="...">
            <a href="{{ route('vehicles.checklist.checklistPdf', [$vehicleChecklistBasic->uuid]) }}" class="btn btn-group btn-icon btn-warning" target="_blank" data-toggle="tooltip" data-placement="left" title="PDF">Gerar PDF
                <i class="bx bxs-file-pdf"></i></a>
        </div>
    </div>
@endsection

@section('content')
    @include('messages')
    @include('error')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="box-title">Checklist Veículo</h3>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        @include("vehicles.includes.checklist_vehicle.checklist_vehicle_basic")
                    </div>
                </div>
            </div>
        </div>
    </div>

    <a class="btn btn-primary" href="{{ url()->previous() }}"><i class="bx bx-arrow-back"></i> Voltar</a>

    <div class="modal fade" id="imgModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Imagem ampliada</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" title="Fechar">
                        <span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div><img class="img-responsive max-75vh" id="recebe-image"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script src="/bower_components/AdminLTE/plugins/select2/select2.full.min.js"></script>
    <script nonce="{{ csp_nonce() }}">

        $(document).on("click", ".open-modal-img", function () {
            let image = $(this).data("image");
            $("#recebe-image").attr("src", image);
        });
        $(function () {
            //Initialize Select2 Elements
            $(".select2").select2({
                allowClear: true,
                width: "100%"
            });
        });
    </script>
@endsection
