@extends('layouts.adminlte')
@section('css')
@endsection
@section('header')
    <div class="page-header">
        <h3>Conclusão - Comunicação / Editar #{{$financial_communication->id}}</h3>
    </div>
    <ol class="breadcrumb">
        <li><a href="/admin"><i class="bx bx-dashboard"></i> Home</a></li>
        <li> Conclusão - Comunicação</li>
        <li class="active">Editar</li>
    </ol>
@endsection

@section('content')
    @include('messages')
    @include('error')

    <div class="row">
        <div class="col-md-12">
            <div class="box box-danger box-solid">
                <div class="box-header">
                    <h3 class="box-title">Editar campos</h3>
                </div>
                <div class="box-body">
                    <form action="{{ route('financial_communications.update', $financial_communication->uuid) }}" method="POST">
                        <div class="padding-10">
                            <input type="hidden" name="_method" value="PUT">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            <div class="form-group col-md-12 {{ $errors->has('status') ? ' has-error' : '' }}">
                                <label for="status">Status</label>
                                <div>
                                    <select class="form-control select2" name="status" data-placeholder="Status" required>
                                        @forelse(financialCommunicationstatusList() as $key=>$value)
                                            <option value="{{$key}}" {{($financial_communication->status == $key || old('status')==$key?"selected":"")}}>{{$value}}</option>
                                        @empty
                                        @endforelse
                                    </select>
                                </div>
                            </div>
                            <div class="form-group col-md-12 {{ $errors->has('message') ? ' has-error' : '' }}">
                                <label for="message">Mensagem</label>
                                <textarea rows="7" class="form-control" name="message" placeholder="Mensagem" autocomplete="off" required>{!! (old('message'))? old('message') : $financial_communication->message !!}</textarea>
                            </div>

                        </div>
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary">Salvar</button>
                            <a class="btn btn-link pull-right" href="{{ route('financial_communications.index') }}"><i class="bx bx-arrow-back"></i> Voltar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
    </script>
@endsection
