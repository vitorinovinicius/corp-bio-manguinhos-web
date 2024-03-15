@extends('layouts.frest_template')
@section('css')
    <!-- Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet"/>
@endsection

@section('content-header')
    <div class="content-header-left col-10 mb-2 mt-1">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h5 class="content-header-title float-left pr-1 mb-0">User - {{ $user->name }} - Associar Grupo</h5>
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb p-0 mb-0">
                        <li class="breadcrumb-item"><i class="bx bx-home-alt"></i> Home</li>
                        <li class="breadcrumb-item">User</li>
                        <li class="breadcrumb-item active">Associar grupos</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    @include('messages')
    @include('error')

    {{--FILTROS INICIO--}}
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Filtro </h4>
                    <a class="heading-elements-toggle">
                        <i class="bx bx-dots-vertical font-medium-3"></i>
                    </a>
                    <div class="heading-elements">
                        <ul class="list-inline mb-0">
                            <li>
                                <a data-action="collapse">
                                    <i class="bx bx-chevron-down"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="card-content collapse show">
                    <div class="card-body">
                        <form class="form form-vertical form_export" method="GET">
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label>Grupos</label>
                                            <select class="form-control group_id" id="group_id" name="group_id">
                                                <option></option>
                                                @foreach ($groups as $group)
                                                    <option value="{{ $group->id }}" data-name="{{$group->name}}">{{ $group->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 d-flex justify-content-end">
                                        <a href="javascript:void(0);" class="btn btn-info" id="btn-external-filter"><i
                                            class="bx bx-plus"></i> OK </a>
                                    </div>
                                </div>
                            </div>
                        </form>
                       
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Grupos </h4>
                    <a class="heading-elements-toggle">
                        <i class="bx bx-dots-vertical font-medium-3"></i>
                    </a>
                    <div class="heading-elements">
                        <ul class="list-inline mb-0">
                            <li>
                                <a data-action="collapse">
                                    <i class="bx bx-chevron-down"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="card-content collapse show">
                    <div class="card-body">
                        <form class="form form-vertical" action="{{ route('groups.associate.store', $user->uuid) }}" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="form-body">
                                <div id="list_group">                                   

                                </div>
                                <div class="col-12 d-flex justify-content-end">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary">Associar</button>
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

    {{--FILTROS FIM--}}

    {{-- <meta name="_token" content="{!! csrf_token() !!}"/> --}}

@section('scripts')
    <!-- Select2 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.js"></script>
    {{-- <script src="/bower_components/AdminLTE/plugins/select2/select2.full.min.js"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>

    <script src="{{asset('vendors/js/pickers/pickadate/picker.js')}}"></script>
    <script src="{{asset('vendors/js/pickers/pickadate/picker.date.js')}}"></script>
    {{-- <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script> --}}
    <script nonce="{{ csp_nonce() }}">
        $(function () {
            $(".select2").select2({
                allowClear: true,
            });            

            $(document).on("click", "#btn-external-filter", function (e) {
                id = $('#group_id').find(':selected').attr('value')
                name = $('#group_id').find(':selected').attr('data-name')
                $('#user_id').val([]);
                e.preventDefault();
                $('<div class="row">' +
                        '<div class="col-2">' +
                            '<div class="form-group">' +
                                '<label for="group_id">ID</label>' +
                                '<input type="text" class="form-control" name="group_ids[]" autocomplete="off" value="'+id+'">' +
                            '</div>' +
                        '</div>' +
                        '<div class="col-8">' +
                            '<div class="form-group">' +
                                '<label for="group_name">Grupo</label>' +
                                '<input type="text" class="form-control" name="group_names[]" value="'+name+'">' +
                                '<i class="bx bx-trash remove-row" style="position: absolute;right: -20px;bottom: 25px;"></i>' +
                            '</div>' +
                        '</div>' +                        
                    '</div>').appendTo("#list_group");
                return false;
            });


        });
    </script>
@endsection