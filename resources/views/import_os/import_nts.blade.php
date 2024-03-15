@extends('layouts.adminlte')
@section('header')
    <div class="page-header clearfix">
        <h3>
            Importar de Ocorrências exclusivamente pela ADM
        </h3>
    </div>
@endsection

@section('content')
    @include('messages')
    @include('error')
    <style nonce="{{ csp_nonce() }}">
        .div-load-max{
            background-color: rgba(239, 217, 217, 0.5);
            position: absolute;
            width: 100%;
            height: 100vh;
            top: 0;
            z-index: 100000;
            left: 0;
        }
        .div-load-max>div{margin-top: 25vh;}
        .div-load-max p, .div-load-max i{
            display: table;
            font-size: 40pt;
            color: #667;
        }
        .div-load-max i{
            margin: 0 auto 30px;
            font-size: 100pt}
        .div-load-max p{
            margin: 0 auto;
            font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif;
        }
    </style>
    <div class="div-load-max" style="display: none;">
        <div>
            <i class="bx bx-refresh fa-spin fa-3x fa-fw"></i>
            <p class="">Aguarde...</p>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="box box-danger">
                <div class="box-body">
                    <div class="box-header with-border">
                        <h3 class="box-title">Fazer a importação das Ordens de Serviços</h3>
                    </div>
                </div>
                <form class="send-form" action="{{ route('importOs.importNts') }}" method="POST" enctype="multipart/form-data">
                    <div class="box-body">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        <div class="form-group">
                            <label for="name_archive">Selecione o arquivo Excel</label>

                            <div><input type="file" class="form-control" name="csv" ></div>
                        </div>
                    </div>

                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary pull-right">Enviar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script nonce="{{ csp_nonce() }}">
        $(document).on("submit",".send-form",function () {
            $(".div-load-max").show();
            $("body").css({"overflow":"hidden"});
        })
    </script>
@endsection
