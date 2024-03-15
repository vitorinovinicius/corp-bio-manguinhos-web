@extends('layouts.frest_template')
@section('css')
    <!-- Select2 -->
    {{-- <link rel="stylesheet" href="/bower_components/AdminLTE/plugins/select2/select2.min.css"> --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet"/>

@endsection
@section('content-header')
    <div class="content-header-left col-10 mb-2 mt-1">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h5 class="content-header-title float-left pr-1 mb-0">Importar Ocorrências</h5>
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb p-0 mb-0">
                        <li class="breadcrumb-item"><i class="bx bx-home-alt"></i> Home</li>
                        <li class="breadcrumb-item">Importação</li>
                        <li class="breadcrumb-item active">Importar Ocorrências</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    @include('messages')
    @include('error')
    <style nonce="{{ csp_nonce() }}">
        .div-load-max {
            position: absolute;
            width: 100%;
            height: 100vh;
            top: 0;
            z-index: 100000;
            left: 0;
        }

        .div-load-max > div {
            margin-top: 25vh;
        }

        .div-load-max p, .div-load-max i {
            display: table;
            font-size: 40pt;
            color: #667;
        }

        .div-load-max i {
            margin: 0 auto 30px;
            font-size: 100pt
        }

        .div-load-max p {
            margin: 0 auto;
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
        }
    </style>
    <div class="div-load-max" style="display: none;">
        <div>
            <i class="bx bx-refresh fa-spin fa-3x fa-fw"></i>
            <p class="">Aguarde...</p>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="box-title">Fazer a importação das Ordens de Serviços através da planilha Excel</h3>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <form class=" form form-vertical send-form" action="{{ route('importOs.import') }}" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="form-body">
                                <div class="row">
                                    @is(['superuser','regiao'])
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Empresa/ Empreiteira*</label>
                                            <select class="form-control select2" name="contractor_id" data-placeholder="Selecione a empresa/empreiteira" required>
                                                <option></option>
                                                @forelse($contractors as $contractor)
                                                    <option value="{{$contractor->id}}" {{(old('contractor_id')==$contractor->id?"selected":"")}}>{{$contractor->name}}</option>
                                                @empty
                                                @endforelse
                                            </select>
                                        </div>
                                    </div>
                                    @endis
                                    <div class="col-md-12">
                                        <fieldset class="form-group">
                                            <label for="csv">Selecione o arquivo Excel</label>
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input form-control" id="inputGroupFile01" name="csv" required accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
                                                <label class="custom-file-label" for="inputGroupFile01">Escolher Arquivo</label>
                                            </div>
                                        </fieldset>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary">Enviar</button>
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
                    <h3 class="box-title">Padrão de campos para importação</h3>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 padding-bottom-20">
                                <a class="btn btn-success" href="{{ URL::asset('archives/Central_System_FSM_Modelo_de_importacao.xlsx') }}">Baixar Modelo de Importação</a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-3">
                                <div class="form-group">
                                    <label for="">Data agendamento <small>Obrigatório</small></label>
                                    <div class="input-static">dd/mm/aaaa</div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-3">
                                <div class="form-group">
                                    <label for="">Hora do agendamento </label>
                                    <div class="input-static">hh:mm</div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-3">
                                <div class="form-group">
                                    <label for="">Turno atendimento</label>
                                    <div class="input-static">
                                        <ul>
                                            <li>Manhã</li>
                                            <li>Tarde</li>
                                            <li>Noite</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-3">
                                <div class="form-group">
                                    <label for="">Número OS</label>
                                    <div class="input-static">Números inteiros</div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="">Nome OS <small>Obrigatório</small></label>
                                    <div class="input-static">Nome do Tipo de Ocorrências
                                        <small>(Consultar menu Administrativo/Tipo de Ocorrências)</small></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-3">
                                <div class="form-group">
                                    <label for="">ID do operador</label>
                                    <div class="input-static">Número do ID do Técnico/Operador</div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-3">
                                <div class="form-group">
                                    <label for="">Número Cliente</label>
                                    <div class="input-static">Número próprio do cliente</div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-3">
                                <div class="form-group">
                                    <label for="">Nome Cliente <small>Obrigatório</small></label>
                                    <div class="input-static">Nome do cliente</div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-3">
                                <div class="form-group">
                                    <label for="">CPF CNPJ</label>
                                    <div class="input-static">CPF ou CNPJ do cliente</div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-3">
                                <div class="form-group">
                                    <label for="">Email</label>
                                    <div class="input-static">E-mail do cliente</div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-3">
                                <div class="form-group">
                                    <label for="">Telefone</label>
                                    <div class="input-static">Telefone do cliente</div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-3">
                                <div class="form-group">
                                    <label for="">Endereço <small>Obrigatório</small></label>
                                    <div class="input-static">Endereço do cliente</div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-3">
                                <div class="form-group">
                                    <label for="">Numero endereço</label>
                                    <div class="input-static">Número do endereço cliente</div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-3">
                                <div class="form-group">
                                    <label for="">Bairro</label>
                                    <div class="input-static">Bairro do cliente</div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-3">
                                <div class="form-group">
                                    <label for="">Município</label>
                                    <div class="input-static">Município/Cidade do cliente</div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-3">
                                <div class="form-group">
                                    <label for="">UF</label>
                                    <div class="input-static">
                                        <ul>
                                            <li>AC</li>
                                            <li>AL</li>
                                            <li>AM</li>
                                            <li>AP</li>
                                            <li>BA</li>
                                            <li>CE</li>
                                            <li>DF</li>
                                            <li>ES</li>
                                            <li>GO</li>
                                            <li>MA</li>
                                            <li>MG</li>
                                            <li>MS</li>
                                            <li>MT</li>
                                            <li>PA</li>
                                            <li>PB</li>
                                            <li>PE</li>
                                            <li>PI</li>
                                            <li>PR</li>
                                            <li>RJ</li>
                                            <li>RN</li>
                                            <li>RO</li>
                                            <li>RR</li>
                                            <li>RS</li>
                                            <li>SC</li>
                                            <li>SE</li>
                                            <li>SP</li>
                                            <li>TO</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-3">
                                <div class="form-group">
                                    <label for="">CEP</label>
                                    <div class="input-static">CEP do cliente</div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-3">
                                <div class="form-group">
                                    <label for="">Prioridade</label>
                                    <div class="input-static">
                                        <ul>0
                                            <li>Baixa</li>
                                            <li>Normal</li>
                                            <li>Alta</li>
                                            <li>Urgente</li>
                                            <li>Especial</li>
                                            <li>Judicial</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="">Obs OS</label>
                                    <div class="input-static">Observação textual sobre a ocorrência. Campo utilizado para enviar ao celular do técnico informações da OS.</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>

    <script nonce="{{ csp_nonce() }}">
        $(".select2").select2({
            allowClear: true,
        });
        $(document).on("submit", ".send-form", function () {
            $(".div-load-max").show();
            $("body").css({"overflow": "hidden"});
        })
    </script>
@endsection
