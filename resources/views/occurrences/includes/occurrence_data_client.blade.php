@if($occurrence->occurrence_data_client)
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="box-title">Dados complementares do cliente no momento do atendimento</h3>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-3">
                                <div class="form-group">
                                    <label for="name">Tipo</label>
                                    <p class="form-control-static">{{ optional($occurrence->occurrence_data_client)->cliente_tipo() }}</p>
                                </div>
                            </div>
                            @if(optional($occurrence->occurrence_data_client)->cliente_tipo_outros)
                                <div class="col-3">
                                    <div class="form-group">
                                        <label for="name">Tipo - Outros</label>
                                        <p class="form-control-static">{{ optional($occurrence->occurrence_data_client)->cliente_tipo() }}</p>
                                    </div>
                                </div>
                            @endif
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="name">Nome</label>
                                    <p class="form-control-static">{{ optional($occurrence->occurrence_data_client)->cliente_nome }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="name">E-mail</label>
                                    <p class="form-control-static">{{ optional($occurrence->occurrence_data_client)->cliente_email }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <!-- <div class="col-3">
                                <div class="form-group">
                                    <label for="name">CPF</label>
                                    <p class="form-control-static">{{ optional($occurrence->occurrence_data_client)->cliente_cpf }}</p>
                                </div>
                            </div> -->
                            <div class="col-3">
                                <div class="form-group">
                                    <label for="name">Telefone</label>
                                    <p class="form-control-static">{{ optional($occurrence->occurrence_data_client)->cliente_telefone }}</p>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label for="name">Quer receber por e-mail?</label>
                                    <p class="form-control-static">{{ sim_nao($occurrence->occurrence_data_client->cliente_recebe_email) }}</p>
                                </div>
                            </div>
                        </div>
                        @if(!empty($occurrence->occurrence_data_client->cliente_assinatura_tecnico))

                            <div class="row">
                                <div class="col-3">
                                    <div class="form-group">
                                        <label for="name">Assinatura do Técnico</label>
                                        <p class="form-control-static">
                                            <img src="data:image/jpeg;base64,{{ base64_encode(@file_get_contents(url(optional($occurrence->occurrence_data_client)->cliente_assinatura_tecnico))) }}" class="img-responsive" style="display: block; max-width: 100%; height:auto; margin: 0 auto;">
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endif
