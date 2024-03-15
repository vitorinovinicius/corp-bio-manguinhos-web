@extends('layouts.frest_template')
@section('css')
    <!-- Select2 -->
    <link rel="stylesheet" href="/bower_components/AdminLTE/plugins/select2/select2.min.css">
@endsection

@section('content-header')
    <div class="content-header-left col-12 mb-2 mt-1">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h5 class="content-header-title float-left pr-1 mb-0">Zona / Criar</h5>
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb p-0 mb-0">
                        <li class="breadcrumb-item"><i class="bx bx-home-alt"></i> Home</li>
                        <li class="breadcrumb-item">Zona</li>
                        <li class="breadcrumb-item active">Criar</li>
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
                    <h3 class="box-title">Criar Zona</h3>
                </div>
              
                <div class="card-content">
                    <div class="card-body">
                        <form class="form form-vertical" action="{{ route('zones.store') }}" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="form-body">  
                                <div class="row">
                                    @is('superuser')
                                        <div class="col-4">
                                            <label>Empreiteira</label>
                                            <select class="form-control select2" name="contractor_id" required data-placeholder="Selecione uma empreiteira" required>
                                                <option></option>
                                                @forelse(\App\Models\Contractor::all() as $contractor)
                                                    <option value="{{$contractor->id}}">{{$contractor->name}}</option>
                                                @empty
                                                @endforelse
                                            </select>
                                        </div> 
                                    @endis                             
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label>Zona</label>
                                            <input type="text" class="form-control" id="zone" name="zone" value="{{ old('zone') }}" placeholder="Zona">
                                        </div>
                                    </div>   
                                </div>
                                
                                <div class="row">
                                    <div class="col-12 d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary">Criar</button>
                                        <a class="btn btn-link pull-right"
                                           href="{{ route('zones.index') }}"><i
                                                class="bx bx-arrow-back"></i> Voltar</a>
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
@section('scripts')
    <!-- Select2 -->
    <script src="/bower_components/AdminLTE/plugins/select2/select2.full.min.js"></script>
    <script>

        $(function () {
            //Initialize Select2 Elements
            $(".select2").select2({
                allowClear: true,
            });
        });        

    </script>

@endsection
