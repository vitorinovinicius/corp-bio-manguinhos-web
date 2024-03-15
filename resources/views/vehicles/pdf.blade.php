<!DOCTYPE html>
<html>
<head>
    <title>Central System - Checklist Veículos Nº {{ $vehicleChecklistBasic->id }}</title>

</head>
<body>
<style nonce="{{ csp_nonce() }}">
    * {
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
    }

    a {
        display: none;
    }

    body {
        font-family: 'Source Sans Pro', 'Helvetica Neue', Helvetica, Arial, sans-serif;
        font-weight: 400;
        overflow-x: hidden;
        font-size: 14px;
        line-height: 1.42857143;
        color: #333;
    }

    .image {
        max-width: 175px !important;
        margin-left: 20px;
        float: left;
    }
    img{
       
    }
    .card{
        margin-left: 20px;
    }
    .content {
        min-height: 250px;
        padding: 15px;
        margin-right: auto;
        margin-left: auto;
    }

    .row {
        margin-right: -15px;
        margin-left: -15px;
    }

    label {
        display: inline-block;
        max-width: 100%;
        margin-bottom: 5px;
        font-weight: 700;
    }

    .form-group h3 {
        margin: 0px 0 0;
    }

    h1, h2, h3, h4, h5, h6, .h1, .h2, .h3, .h4, .h5, .h6 {
        font-family: 'Source Sans Pro', sans-serif;
    }

    .h3, h3, h4 {
        font-size: 24px;
    }

    .h1, .h2, .h3, h1, h2, h3 {
        margin-top: 20px;
        margin-bottom: 10px;
    }

    .h1, .h2, .h3, .h4, .h5, .h6, h1, h2, h3, h4, h5, h6 {
        font-family: inherit;
        font-weight: 500;
        line-height: 1.1;
        color: inherit;
    }

    .box {
        position: relative;
        border-radius: 3px;
        background: #ffffff;
        border-top: 3px solid #d2d6de;
        margin-bottom: 20px;
        width: 100%;
        box-shadow: 0 1px 1px rgba(0, 0, 0, 0.1);
    }

    .box.box-solid.box-default > .box-header {
        color: #444;
        background: #d2d6de;
        background-color: #d2d6de;
    }

    .box.box-danger {
        border-top-color: #dd4b39;
    }

    .box.box-solid.box-danger {
        border: 1px solid #dd4b39;
    }

    .box.box-solid.box-danger > .box-header {
        color: #fff;
        background: #dd4b39;
        background-color: #dd4b39;
    }

    .box.box-solid.box-info > .box-header {
        color: #fff;
        background: #00c0ef;
        background-color: #00c0ef;
    }

    .box.box-solid.box-primary {
        border: 1px solid #3c8dbc;
    }

    .box.box-default {
        border-top-color: #d2d6de;
    }

    .box.box-solid.box-default {
        border: 1px solid #d2d6de;
    }

    .box-body {
        border-top-left-radius: 0;
        border-top-right-radius: 0;
        border-bottom-right-radius: 3px;
        border-bottom-left-radius: 3px;
        padding: 10px;
        display: table;
        width: 100%;
    }

    .box-header > .fa, .box-header > .glyphicon, .box-header > .ion, .box-header .box-title {
        display: inline-block;
        font-size: 18px;
        margin: 0;
        line-height: 1;
    }

    .box.box-solid.box-primary > .box-header {
        color: #fff;
        background: #3c8dbc;
    }

    .box-header {
        color: #444;
        display: block;
        padding: 10px;
        position: relative;
    }

    .form-group {
        padding: 5px 10px;
        margin-bottom: 15px;
    }

    .form-group .input-static {
        border: 1px solid #ccc;
        background: #f6f6f6;
        padding: 5px;
        min-height: 32px;
    }

    .col-md-1, .col-md-10, .col-md-11, .col-md-12, .col-md-2, .col-md-3, .col-md-4, .col-md-5, .col-md-6, .col-md-7, .col-md-8, .col-md-9 {
        position: relative;
        min-height: 1px;
        padding-right: 15px;
        padding-left: 15px;
    }

    .col-md-1, .col-md-2, .col-md-3, .col-md-4, .col-md-5, .col-md-6, .col-md-7, .col-md-8, .col-md-9, .col-md-10, .col-md-11, .col-md-12 {
        float: left;
        display: inline-table;
    }

    .col-md-12 {
        width: 100%;
    }

    .col-md-11 {
        width: 91.66666667%;
    }

    .col-md-10 {
        width: 83.33333333%;
    }

    .col-md-9 {
        width: 75%;
    }

    .col-md-8 {
        width: 66.66666667%;
    }

    .col-md-7 {
        width:100%;
    }

    .col-md-6 {
        width: 50%;
    }

    .col-md-5 {
        width: 38.66666667%;
    }

    .col-md-4 {
        width: 33.33333333%;
    }

    .col-md-3 {
        width: 25%;
    }

    .col-md-2 {
        width: 30.66666667%;
    }

    .col-md-1 {
        width: 8.33333333%;
    }

    .page-break {
        page-break-after: always;
    }

    .page-number:before {
        content: "Página " counter(page);
    }

    .box-header:before, .box-body:before, .box-footer:before, .box-header:after, .box-body:after, .box-footer:after, .btn-group-vertical > .btn-group:after, .btn-group-vertical > .btn-group:before, .btn-toolbar:after, .btn-toolbar:before, .clearfix:after, .clearfix:before, .container-fluid:after, .container-fluid:before, .container:after, .container:before, .dl-horizontal dd:after, .dl-horizontal dd:before, .form-horizontal .form-group:after, .form-horizontal .form-group:before, .modal-footer:after, .modal-footer:before, .modal-header:after, .modal-header:before, .nav:after, .nav:before, .navbar-collapse:after, .navbar-collapse:before, .navbar-header:after, .navbar-header:before, .navbar:after, .navbar:before, .pager:after, .pager:before, .panel-body:after, .panel-body:before, .row:after, .row:before {
        content: " ";
        display: table;
    }

    .btn-group-vertical > .btn-group:after, .btn-group-vertical > .btn-group:before, .btn-toolbar:after, .btn-toolbar:before, .clearfix:after, .clearfix:before, .container-fluid:after, .container-fluid:before, .container:after, .container:before, .dl-horizontal dd:after, .dl-horizontal dd:before, .form-horizontal .form-group:after, .form-horizontal .form-group:before, .modal-footer:after, .modal-footer:before, .modal-header:after, .modal-header:before, .nav:after, .nav:before, .navbar-collapse:after, .navbar-collapse:before, .navbar-header:after, .navbar-header:before, .navbar:after, .navbar:before, .pager:after, .pager:before, .panel-body:after, .panel-body:before, .row:after, .row:before
    .box-header:after, .box-body:after, .box-footer:after {
        clear: both;
    }

    :after, :before {
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
    }

    .input-group {
        position: relative;
        display: table;
        border-collapse: separate;
    }

    .form-group .input-static {
        border: 1px solid #ccc;
        background: #f6f6f6;
        padding: 5px 15px;
        min-height: 32px;
    }

    .input-group-addon {
        padding: 6px 12px;
        font-size: 14px;
        font-weight: 400;
        line-height: 1;
        color: #555;
        text-align: center;
        background-color: #eee;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    .input-group-addon, .input-group-btn {
        width: 1%;
        white-space: nowrap;
        vertical-align: middle;
    }

    .input-group .form-control, .input-group-addon, .input-group-btn {
        display: table-cell;
    }

    /*TABLE*/
    .box-body > .table {
        margin-bottom: 0;
    }

    .table-bordered {
        border: 1px solid #f4f4f4;
    }

    .table-responsive {
        min-height: .01%;
        overflow-x: auto;
    }

    .table-bordered {
        border: 1px solid #ddd;
    }

    .table {
        width: 100%;
        max-width: 100%;
        margin-bottom: 20px;
    }

    table {
        background-color: transparent;
    }

    table {
        border-spacing: 0;
        border-collapse: collapse;
    }

    .table > caption + thead > tr:first-child > td, .table > caption + thead > tr:first-child > th, .table > colgroup + thead > tr:first-child > td, .table > colgroup + thead > tr:first-child > th, .table > thead:first-child > tr:first-child > td, .table > thead:first-child > tr:first-child > th {
        border-top: 0;
    }

    .table-bordered > thead > tr > th, .table-bordered > thead > tr > td {
        border-bottom-width: 2px;
    }

    .table-bordered > thead > tr > th, .table-bordered > tbody > tr > th, .table-bordered > tfoot > tr > th, .table-bordered > thead > tr > td, .table-bordered > tbody > tr > td, .table-bordered > tfoot > tr > td {
        border: 1px solid #f4f4f4;
    }

    .table > thead > tr > th {
        border-bottom: 2px solid #f4f4f4;
    }

    .table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {
        border-top: 1px solid #f4f4f4;
    }

    .table > tbody > tr > td, .table > tbody > tr > th, .table > tfoot > tr > td, .table > tfoot > tr > th, .table > thead > tr > td, .table > thead > tr > th {
        vertical-align: middle;
    }

    .table > thead > tr > th {
        text-align: center;
    }

    .table-bordered > thead > tr > td, .table-bordered > thead > tr > th {
        border-bottom-width: 2px;
    }

    .table-bordered > tbody > tr > td, .table-bordered > tbody > tr > th, .table-bordered > tfoot > tr > td, .table-bordered > tfoot > tr > th, .table-bordered > thead > tr > td, .table-bordered > thead > tr > th {
        border: 1px solid #ddd;
    }

    .table > thead > tr > th {
        vertical-align: bottom;
        border-bottom: 2px solid #ddd;
    }

    .table > tbody > tr > td, .table > tbody > tr > th, .table > tfoot > tr > td, .table > tfoot > tr > th, .table > thead > tr > td, .table > thead > tr > th {
        padding: 8px;
        line-height: 1.42857143;
        vertical-align: top;
        border-top: 1px solid #ddd;
    }

    .table-striped > tbody > tr:nth-of-type(odd) {
        background-color: #f9f9f9;
    }

    .table-bordered > thead > tr > th, .table-bordered > tbody > tr > th, .table-bordered > tfoot > tr > th, .table-bordered > thead > tr > td, .table-bordered > tbody > tr > td, .table-bordered > tfoot > tr > td {
        border: 1px solid #f4f4f4;
    }

    .table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {
        border-top: 1px solid #f4f4f4;
    }

    .table > tbody > tr > td, .table > tbody > tr > th, .table > tfoot > tr > td, .table > tfoot > tr > th, .table > thead > tr > td, .table > thead > tr > th {
        vertical-align: middle;
    }

    .table > tbody > tr > td {
        text-align: center;
    }

    .table-bordered > tbody > tr > td, .table-bordered > tbody > tr > th, .table-bordered > tfoot > tr > td, .table-bordered > tfoot > tr > th, .table-bordered > thead > tr > td, .table-bordered > thead > tr > th {
        border: 1px solid #ddd;
    }

    .table > tbody > tr > td, .table > tbody > tr > th, .table > tfoot > tr > td, .table > tfoot > tr > th, .table > thead > tr > td, .table > thead > tr > th {
        padding: 8px;
        line-height: 1.42857143;
        vertical-align: top;
        border-top: 1px solid #ddd;
    }

    /*FIM TABLE*/

    .label-default {
        background-color: #d2d6de;
        color: #444;
    }

    .label {
        display: inline;
        padding: .2em .6em .3em;
        font-size: 75%;
        font-weight: 700;
        line-height: 1;
        color: #fff;
        text-align: center;
        white-space: nowrap;
        vertical-align: baseline;
        border-radius: .25em;
    }

    .label-danger,
    .label-info,
    .label-warning,
    .label-primary,
    .label-success {
        color: #fff !important;
    }

    .label-danger {
        background-color: #dd4b39 !important;
    }

    .label-warning {
        background-color: #f39c12 !important;
    }

    .label-info {
        background-color: #00c0ef !important;
    }

    .label-primary {
        background-color: #3c8dbc !important;
    }

    .label-success {
        background-color: #00a65a !important;
    }

    .hidden-print, .hidden-pdf {
        display: none !important;
    }

</style>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-solid box-danger">
                <div class="box-header">
                    <h3 class="box-title">Checklist Veículo</h3>
                </div>
                <div class="box-body">
                    <p style="font-size: 18px"><strong>Empreiteira:</strong> {{$vehicleChecklistBasic->contractor->name}}</p>
                    <hr>
                    <table class="table table-condensed table-striped table-sm table-hover">
                        <thead>
                        <tr>
                            <th>Placa</th>
                            <th>Data ínicio</th>
                            <th>Data fim</th>
                            <th>Recebido no servidor</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>{{$vehicleChecklistBasic->placa}}</td>
                            <td>@if($vehicleChecklistBasic->check_in_date) {{\Carbon\Carbon::parse($vehicleChecklistBasic->check_in_date)->format("d/m/Y H:i:s")}} @endif</td>
                            <td>@if($vehicleChecklistBasic->finish_date) {{\Carbon\Carbon::parse($vehicleChecklistBasic->finish_date)->format("d/m/Y H:i:s")}} @endif</td>
                            <td>{{\Carbon\Carbon::parse($vehicleChecklistBasic->created_at)->format("d/m/Y H:i:s")}}</td>
                        </tr>
                        </tbody>
                    </table>
                    {{--DADOS BÁSICOS--}}
                    @include('vehicles.includes.checklist_vehicle.checklist_vehicle_basic')

                </div>
            </div>
        </div>
    </div>
</section>
</body>
</html>
