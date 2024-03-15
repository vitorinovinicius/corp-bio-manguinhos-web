@if($occurrence->occurrence_data_basic AND $occurrence->is_manual == 1)
    <div class="row page-break">
        <div class="col-md-12">
            <div class="box box-solid box-danger">
                <div class="box-header">
                    <h3 class="box-title">Dados complementares</h3>

                    <div class="box-tools pull-right hidden-print">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse">
                            <i class="bx bx-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group col-md-3">
                                <label for="data_agendamento">Data Agendamento</label>
                                <div class="form-control input-static">{{ $occurrence->occurrence_data_basic->data_agendamento }}</div>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="empreiteira">Empreiteira</label>
                                <div class="form-control input-static">{{ $occurrence->occurrence_data_basic->empreiteira }}</div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group col-md-3">
                                <label for="numero_os">Número OS</label>
                                <div class="form-control input-static">{{ $occurrence->occurrence_data_basic->numero_os }}</div>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="nome_os">Nome OS</label>
                                <div class="form-control input-static">{{ $occurrence->occurrence_data_basic->nome_os }}</div>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="numero_cliente">Número Cliente</label>
                                <div class="form-control input-static">{{ $occurrence->occurrence_data_basic->numero_cliente }}</div>
                            </div>
                            <div class="form-group col-md-7">
                                <label for="nome_cliente">Nome Cliente</label>
                                <div class="form-control input-static">{{ $occurrence->occurrence_data_basic->nome_cliente }}</div>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="endereco">Endereço</label>
                                <div class="form-control input-static">{{ $occurrence->occurrence_data_basic->endereco }}</div>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="bairro">Bairro</label>
                                <div class="form-control input-static">{{ $occurrence->occurrence_data_basic->bairro }}</div>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="municipio">Município</label>
                                <div class="form-control input-static">{{ $occurrence->occurrence_data_basic->municipio }}</div>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="telefone1">Telefone</label>
                                <div class="form-control input-static">{{ $occurrence->occurrence_data_basic->telefone1 }}</div>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="telefone2">Telefone</label>
                                <div class="form-control input-static">{{ $occurrence->occurrence_data_basic->telefone2 }}</div>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="telefone3">Telefone</label>
                                <div class="form-control input-static">{{ $occurrence->occurrence_data_basic->telefone3 }}</div>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="prioridade">Prioridade</label>
                                <div class="form-control input-static">{{ $occurrence->occurrence_data_basic->prioridade }}</div>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
