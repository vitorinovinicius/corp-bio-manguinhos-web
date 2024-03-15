@extends('layouts.frest_template')
@section('css')
    <!-- Select2 -->
    <link rel="stylesheet" href="/bower_components/AdminLTE/plugins/select2/select2.min.css">
@endsection

@section('content-header')
    <div class="content-header-left col-12 mb-2 mt-1">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h5 class="content-header-title float-left pr-1 mb-0">Zona / Editar #{{$zone->id}}</h5>
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb p-0 mb-0">
                        <li class="breadcrumb-item"><i class="bx bx-home-alt"></i> Home</li>
                        <li class="breadcrumb-item">Zona</li>
                        <li class="breadcrumb-item active">Editar</li>
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
                    <h3 class="box-title">Zona</h3>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <form class="form form-vertical" action="{{ route('zones.update', $zone->uuid) }}" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="_method" value="PUT">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="form-body">
                                <div class="row">
                                    @is('superuser')
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label>Empreiteira</label>
                                            <select class="form-control select2" name="contractor_id" required data-placeholder="Selecione uma empreiteira" required>
                                                <option></option>
                                                @forelse(\App\Models\Contractor::all() as $contractor)
                                                    <option value="{{$contractor->id}}" @if($contractor->id == $zone->contractor_id) SELECTED @endif>{{$contractor->name}}</option>
                                                @empty
                                                @endforelse
                                            </select>
                                        </div>
                                    </div>
                                    @endis
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label>Zona</label>
                                            <input type="text" class="form-control" id="zone" name="zone" value="{{ (old('zone'))? old('zone') : $zone->zone }}" placeholder="Name">
                                        </div>
                                    </div>                                    
                                </div>                               
                            </div>
                 
                            <div class="row">
                                <div class="col-12 d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary">Salvar</button>
                                    <a class="btn btn-link pull-right"
                                    href="{{ route('zones.index') }}"><i
                                            class="bx bx-arrow-back"></i> Voltar</a>
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
    <!-- Datepicker -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.0/js/bootstrap-datepicker.min.js"></script>
    <script>
        $(".form-check-input").click(function(){           
            var id = $(this).attr("id");           
            if($(this).is(':checked') == true){
             $("[data-name='"+id+"']").removeAttr('readonly');
             $("[data-name='"+id+"']").attr('required', true);
            }else{
             $("[data-name='"+id+"']").val(0);
             $("[data-name='"+id+"']").attr('readonly', true);
            }           
         })
    </script>
@endsection
