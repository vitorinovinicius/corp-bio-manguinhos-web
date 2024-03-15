<div class="row">
    <div class="col-md-12">
        <div class="box box-solid box-default">
            <div class="box-header">
                <h3 class="box-title">Dados do cliente</h3>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group col-md-4">
                            <label for="occurrence_client_id">Nome completo do cliente</label>
                            <div class="input-static">{{$occurrence->occurrence_client->name}}</div>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="cpf_cnpj">CPF</label>
                            <div class="input-static">{{$occurrence->occurrence_client->cpf_cnpj}}</div>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="cpf_cnpj">E-mail</label>
                            <div class="input-static">{{$occurrence->occurrence_client->email}}</div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group col-md-4">
                            <label for="phone">Telefones</label>
                        </div>
                        <div class="col-md-12 noPadding-left">
                            @forelse($occurrence->occurrence_client->occurrence_client_phones as $key => $phones)

                                <div class="form-group col-md-4">
                                    <div class="input-group" style="margin-bottom: 5px;">
                                        <div class="input-static">{{$phones->phone}}</div>
                                    </div>
                                </div>

                            @empty
                                <div class="input-static">Não há telefone associado</div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group col-md-5">
                            <label for="address">Endereço</label>
                            <div class="input-static">{{ $occurrence->occurrence_client->address }}</div>
                        </div>

                        <div class="form-group col-md-3">
                            <label for="district">Bairro</label>
                            <div class="input-static">{{ $occurrence->occurrence_client->district }}</div>
                        </div>

                        <div class="form-group col-md-3">
                            <label for="city">Cidade/ Município</label>
                            <div class="input-static">{{ $occurrence->occurrence_client->city }}</div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <a href="{{route('occurrence_clients.show',$occurrence->occurrence_client->uuid)}}" class="btn btn-primary pull-right" target="_blank"><i class="bx bx-edit"></i> Exibir cliente</a>
                        <a href="{{route('occurrence_clients.edit',$occurrence->occurrence_client->uuid)}}" class="btn btn-warning pull-right" target="_blank"><i class="bx bx-edit"></i> Editar cliente</a>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>
