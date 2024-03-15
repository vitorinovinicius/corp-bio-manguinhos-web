@extends('layouts.frest_template')
@section('css')
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/css/pickers/daterange/daterangepicker.css')}}">
    <!-- Select2 -->
    <link rel="stylesheet" href="/bower_components/AdminLTE/plugins/select2/select2.min.css">
@endsection

@section('content-header')
    <div class="content-header-left col-12 mb-2 mt-1">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h5 class="content-header-title float-left pr-1 mb-0">Exportar Ocorrências</h5>
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb p-0 mb-0">
                        <li class="breadcrumb-item"><i class="bx bx-home-alt"></i> Home</li>
                        <li class="breadcrumb-item active">Exportar Ocorrências</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    @include('messages')
    @include('error')
    @include('helpers/filter_occurrences')

@endsection
@section('scripts')
    <script nonce="{{ csp_nonce() }}">
        $(function () {
            $(document).on('click','.btnGerar', function (e) {

            $.ajaxSetup({
                    headers:{'X-CSRF-Token': '{{ csrf_token() }}'}
                });

                    e.preventDefault();
                    $('.form_export').attr('action', "{{ route('export.export') }}").submit();
            });
        });


    </script>
@endsection
