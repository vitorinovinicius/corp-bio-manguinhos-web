@extends('layouts.frest_template')
@section('css')
    <!-- Select2 -->
    <link rel="stylesheet" href="/bower_components/AdminLTE/plugins/select2/select2.min.css">
@endsection
@section('content-header')
    <div class="content-header-left col-12 mb-2 mt-1">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h5 class="content-header-title float-left pr-1 mb-0">Item checklist de veículos / Editar #{{$checklistVehicleIten->id}}</h5>
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb p-0 mb-0">
                        <li class="breadcrumb-item"><i class="bx bx-home-alt"></i> Home</li>
                        <li class="breadcrumb-item">Item checkliste veículos</li>
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
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="box-title">Item checkliste veículos</h3>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <form class="form form-vertical" action="{{ route('checklist_vechicle_itens.update', $checklistVehicleIten->uuid) }}" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="_method" value="PUT">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="form-body">
                                <div class="row">
                                    <div class="form-group col-md-4" {{ $errors->has('descricao') ? ' has-error' : '' }}>
                                        <label for="year">Descrição</label>
                                        <input type="text" class="form-control" id="descricao" name="descricao" value="{{ (old('descricao'))? old('descricao') : $checklistVehicleIten->descricao }}" placeholder="Descrição">
                                    </div>
        
                                    <div class="form-group col-md-4" {{ $errors->has('type_id') ? ' has-error' : '' }}>
                                        <label for="client_number">Tipo</label>
                                        <div>
                                            <select class="form-control select2" name="type_id" required data-placeholder="Selecione tipo de veículo" required>
                                                <option></option>
                                                @foreach(tipoChecklistVehicles() as $key=>$type)
                                                    <option value="{{$key}}"  @if($checklistVehicleIten->type_id == $key) SELECTED @endif>{{$type}}</option>
                                               @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary">Salvar</button>
                                        <a class="btn btn-link pull-right" href="{{ route('checklist_vechicle_itens.index') }}"><i class="bx bx-arrow-back"></i>  Voltar</a>
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
    <!-- Datepicker -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.0/js/bootstrap-datepicker.min.js"></script>

    <script nonce="{{ csp_nonce() }}">
        $(document).on("click", ".removeImage", function (e) {
            e.preventDefault();
            var status = confirm("Deseja realmente remover essa Imagem?");
            if (status == false) {
                return false;
            }
            var id = $(this).data("id");
            var url = $(this).data("url");
            var this2 = $(this);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            }),
                jQuery.ajax({
                    type: 'POST',
                    url: '{{route("archive.destroy")}}',
                    data: "id=" + id + "&url=" + url,

                    success: function (data) {
                        if (data.retorno == 2) {
                            alert(data.mensagem);
                        } else {
                            alert(data.mensagem);
                            $(this2).parent().remove();
                        }
                    },
                    error: function () {
                        alert("Ocorreu um erro inesperado durante o processamento!\n Recarrege a página e tente novamente.");
                    }
                });
            return false;
        });


    </script>



@endsection
