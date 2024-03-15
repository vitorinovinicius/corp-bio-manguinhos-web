@extends('layouts.frest_template')
@section('css')
@endsection

@section('content-header')
    <div class="content-header-left col-12 mb-2 mt-1">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h5 class="content-header-title float-left pr-1 mb-0">Conclusão - Liberação / Editar #{{$financial->id}}</h5>
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb p-0 mb-0">
                        <li class="breadcrumb-item"><i class="bx bx-home-alt"></i> Home</li>
                        <li class="breadcrumb-item">Conclusão - Liberação</li>
                        <li class="breadcrumb-item active">Editar #{{$financial->id}}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
@include('messages')
@include('error')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="box-title">Editar Conclusão - Liberação #{{$financial->id}}</h3>
            </div>
            <div class="card-content">
                <div class="card-body">
                    <form class="form form-vertical" action="{{ route('financials.update', $financial->uuid) }}" method="POST">
                        <input type="hidden" name="_method" value="PUT">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="form-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="name">ID OS interno</label>
                                        <input type="text" class="form-control" name="name" value="{{$financial->occurrence->id}}" placeholder="Nome" readonly>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="name">Numero OS</label>
                                        <input type="text" class="form-control" name="name" value="{{$financial->occurrence->numero_os}}" placeholder="Nome" readonly>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="name">Status</label>
                                        <select class="form-control select2" name="status" required data-placeholder="Status">
                                            @forelse(FinancialstatusList() as $key=>$value)
                                                <option value="{{$key}}" {{($financial->status == $key || old('status')==$key?"selected":"")}}>{{$value}}</option>
                                            @empty
                                            @endforelse
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="name">Mensagem</label>
                                        <textarea rows="7" class="form-control" name="message" placeholder="Mensagem"  autocomplete="off" required>{!! (old('message'))? old('message') : $financial->message !!}</textarea>
                                    </div>
                                </div>
                                <div class="col-12 d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary">Salvar</button>
                                    <a class="btn btn-link pull-right"
                                       href="{{ route('financials.index') }}"><i
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
<script>
</script>
@endsection
