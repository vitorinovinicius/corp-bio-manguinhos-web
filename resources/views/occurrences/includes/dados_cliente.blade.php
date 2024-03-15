<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="box-title">Dados do cliente</h3>
            </div>
            <div class="card-content">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="name">Nome completo do cliente</label>
                                        <p class="form-control-static" id="client_name">{{optional($occurrence->occurrence_client)->name}}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 hidden-sms">
                                    <div class="form-group">
                                        <label for="name">E-mail</label>
                                        <p class="form-control-static" id="email">{{optional($occurrence->occurrence_client)->email}}</p>
                                    </div>
                                </div>
                                {{-- <div class="col-md-4 hidden-pdf hidden-sms">
                                    <div class="form-group">
                                        <label for="name">CPF ou CNPJ</label>
                                        <p class="form-control-static" id="cpf_cnpj">{{optional($occurrence->occurrence_client)->cpf_cnpj}}</p>
                                    </div>
                                </div> --}}
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Número externo do cliente</label>
                                        <p class="form-control-static" id="id_client">{{optional($occurrence->occurrence_client)->client_number}}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 hidden-sms">
                                    <div class="form-group ">
                                        <label for="name">Telefones</label>
                                        @if($occurrence->occurrence_client)
                                            @forelse($occurrence->occurrence_client->occurrence_client_phones as $phone)
                                                <p class="form-control-static" id="phone">{{$phone->phone}}</p>
                                            @empty
                                                <p class="form-control-static" id="phone">Não há telefone associado</p>
                                            @endforelse
                                            <p class="form-control-static" id="phone">Não há telefone associado</p>
                                        @else
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="name">Endereço</label>
                                        <p class="form-control-static" id="address">{{optional($occurrence->occurrence_client)->address}}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3 hidden-sms">
                                    <div class="form-group">
                                        <label for="name">Nº</label>
                                        <p class="form-control-static" id="number">{{optional($occurrence->occurrence_client)->number}}</p>
                                    </div>
                                </div>
                                <div class="col-md-3 hidden-sms">
                                    <div class="form-group">
                                        <label for="name">Bairro</label>
                                        <p class="form-control-static" id="district">{{optional($occurrence->occurrence_client)->district}}</p>
                                    </div>
                                </div>
                                <div class="col-md-3 hidden-sms">
                                    <div class="form-group">
                                        <label for="name">Cidade</label>
                                        <p class="form-control-static" id="city">{{optional($occurrence->occurrence_client)->city}}</p>
                                    </div>
                                </div>
                                <div class="col-md-3 hidden-sms">
                                    <div class="form-group">
                                        <label for="name">Estado</label>
                                        <p class="form-control-static" id="uf">{{getToUf(optional($occurrence->occurrence_client)->uf)}}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label for="name">Zona</label>
                                    <p class="form-control-static" id="zone">{{optional($occurrence->zone)->zone}}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 hidden-sms">
                                    <div class="form-group">
                                        <label for="name">Complemento</label>
                                        <p class="form-control-static" id="complement">{{optional($occurrence->occurrence_client)->complement}}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 hidden-sms">
                                    <div class="form-group">
                                        <label for="name">Referência</label>
                                        <p class="form-control-static" id="reference">{{optional($occurrence->occurrence_client)->reference}}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
