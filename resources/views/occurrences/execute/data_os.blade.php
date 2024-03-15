<div class="card">
    <div class="card-header">
        <h3 class="box-title">Dados da OS</h3>
    </div>
    <div class="card-content">
        <div class="card-body">
            <div class="row">
                <div class="col-2">
                    <div class="form-group">
                        <label>Número OS</label>
                        <input type="text" autocomplete="off" class="form-control" id="numero_os" name="numero_os" value="{{ old('numero_os', $occurrence->numero_os) }}" readonly>
                    </div>
                </div>
                @if($occurrence->status == 1)
                    <div class="col-3">
                        <div class="form-group">
                            <label>Data do agendamento</label>
                            <input type="text" autocomplete="off" class="form-control date-picker" id="schedule_date" name="schedule_date" value="{{ old('schedule_date', $occurrence->schedule_date) }}" readonly>
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="form-group">
                            <label>Hora do agendamento</label>
                            <input type="time" autocomplete="off" class="form-control" id="schedule_time" name="schedule_time" value="{{ old('schedule_time', $occurrence->schedule_time) }}" disabled>
                        </div>
                    </div>
                @endif
                <div class="col-5">
                    <div class="form-group">
                        <label>Prioridade*</label>

                        <select class="form-control select2" name="priority" disabled>
                            <option></option>
                            @forelse(priority_list_array() as $key=>$value)
                                <option value="{{$key}}" {{(old('priority',$occurrence->priority) || ($occurrence->priority)==$key?"selected":"")}}>{{$value}}</option>
                            @empty
                            @endforelse
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                @is(['superuser'])
                <div class="col-12">
                    <div class="form-group">
                        <label>Empresa/ Empreiteira*</label>
                        <select class="form-control select2" name="contractor_id" data-placeholder="Selecione a empresa/empreiteira" disabled>
                            <option></option>
                            @forelse($contractors as $contractor)
                                <option value="{{$contractor->id}}" {{(old('contractor_id') || ($occurrence->contractor_id)==$contractor->id?"selected":"")}}>{{$contractor->name}}</option>
                            @empty
                            @endforelse
                        </select>
                    </div>
                </div>
                @endis

                <div class="col-12">
                    <div class="form-group">
                        <label>Tipo da Ocorrência*</label>
                        <select class="form-control select2" name="occurrence_type_id" data-placeholder="Selecione o tipo da Ocorrência" disabled>
                            <option></option>
                            @forelse($occurrence_types as $ot)
                                <option value="{{$ot->id}}" {{(old('occurrence_type_id')|| ($occurrence->occurrence_type_id)==$ot->id?"selected":"")}}>{{$ot->name}}</option>
                            @empty
                            @endforelse
                        </select>
                    </div>
                </div>

                <div class="col-12">
                    <div class="form-group">
                        <label>Atribuir para:
                            <span class="text-danger text-sm"> Não obrigatório </span></label>
                        <select class="form-control select2" name="operator_id" data-placeholder="Escolha um Operador" desable>
                            <option></option>
                            @forelse($operators as $operator)
                                <option value="{{$operator->id}}" {{($operator->id == $occurrence->operator_id ? "selected" : "")}}>{{$operator->name}}</option>
                            @empty
                            @endforelse
                        </select>
                    </div>
                </div>

                <div class="col-12">
                    <div class="form-group">
                        <label>Observação</label>
                        <div class="form-control" id="obs_empreiteira" name="obs_empreiteira">{{ (old('obs_empreiteira'))? old('obs_empreiteira') : $occurrence->obs_empreiteira}}</div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="form-group">
                        <label>Selecione o cliente</label>
                        <select class="form-control occurrence_client_id" id="occurrence_client_id" name="occurrence_client_id" disabled>
                            <option></option>
                            @if($occurrence->occurrence_client)
                                <option value="{{ $occurrence->occurrence_client_id }}" selected>{{ optional($occurrence->occurrence_client)->client_number ? optional($occurrence->occurrence_client)->client_number . " | " : "" }} {{ optional($occurrence->occurrence_client)->name }} | CPF/CNPJ: {{ optional($occurrence->occurrence_client)->cpf_cnpj }} | E-mail: {{ optional($occurrence->occurrence_client)->email }}</option>
                            @endif
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card-content">
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="box-title">Dados do cliente</h3>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-8">
                                        <div class="form-group">
                                            <label>Nome completo do cliente</label>
                                            <input type="text" autocomplete="off" class="form-control" id="client_name" name="name" value="{{ old('name')? old('name') : optional($occurrence->occurrence_client)->name }}" placeholder="Nome completo do cliente" required>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label>Número externo do cliente</label>
                                            <input type="text" autocomplete="off" class="form-control" id="client_number" name="client_number" value="{{ old('client_number')?  old('client_number') : optional($occurrence->occurrence_client)->client_number }}" placeholder="Nº cliente">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label>E-mail</label>
                                            <input type="email" class="form-control" id="email" name="email" value="{{ old('email')?  old('email') : optional($occurrence->occurrence_client)->email }}" placeholder="email">
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label>CPF ou CNPJ</label>
                                            <input type="text" autocomplete="off" class="form-control" id="cpf_cnpj" name="cpf_cnpj" value="{{ old('cpf_cnpj')?  old('cpf_cnpj') : optional($occurrence->occurrence_client)->cpf_cnpj }}" placeholder="CPF ou CNPJ">
                                        </div>
                                    </div>
                                </div>

                                <div class="divPhonePrincipal">
                                    @foreach(optional($occurrence->occurrence_client)->occurrence_client_phones as $occurrence_client_phone)
                                        <div class="row">
                                            <div class="col-4">
                                                <div class="form-group">
                                                    <label for="phones">Telefone</label>
                                                    <input type="text" class="form-control" id="phones" name="phones[]"
                                                           autocomplete="off" placeholder="Telefone" value="{{$occurrence_client_phone->phone}}" readonly>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="form-group">
                                                    <label for="Obs">Obs</label>
                                                    <input type="text" class="form-control" id="obs" name="obs[]"
                                                           autocomplete="off" placeholder="Observação" value="{{ $occurrence_client_phone->obs }}" readonly>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="divPhoneNew">
                                </div>
                                <div class="row add-phone" style="display: none;">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <a href="javascript:void(0);" class="btn btn-info" id="addPhone"><i
                                                    class="bx bx-plus"></i> Adicionar telefone</a>
                                        </div>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label>CEP</label>
                                            <div>
                                                <input type="text" autocomplete="off" class="form-control" style="width: calc(100% - 95px);display: inline-block; margin-right: 6px;" id="cep" name="cep" value="{{ old('cep')?  old('cep') : optional($occurrence->occurrence_client)->cep }}" placeholder="CEP" required>
                                                <a href="javascript:return void(0);" id="busca_cep" class="btn-sm btn-success right">Buscar</a>
                                                <i class="cs-loading" style="display:none;"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-10">
                                        <div class="form-group">
                                            <label>Endereço</label>
                                            <input type="text" autocomplete="off" class="form-control" id="address" name="address" value="{{ old('address')?  old('address') : optional($occurrence->occurrence_client)->address }}" placeholder="Endereço" required>
                                        </div>
                                    </div>
                                    <div class="col-2">
                                        <div class="form-group">
                                            <label for="number">Nº</label>
                                            <input type="text" class="form-control" id="number" name="number"
                                                   value="{{ (old('number'))? old('number') : optional($occurrence->occurrence_client)->number}}" autocomplete="off" placeholder="Nº">
                                        </div>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-5">
                                        <div class="form-group">
                                            <label>Bairro</label>
                                            <input type="text" autocomplete="off" class="form-control" id="district" name="district" value="{{ old('district')?  old('district') : optional($occurrence->occurrence_client)->district }}" placeholder="Bairro" required>
                                        </div>
                                    </div>
                                    <div class="col-5">
                                        <div class="form-group">
                                            <label>Cidade</label>
                                            <input type="text" autocomplete="off" class="form-control" id="city" name="city" value="{{ old('city')?  old('city') : optional($occurrence->occurrence_client)->city }}" placeholder="Cidade" required>
                                        </div>
                                    </div>
                                    <div class="col-2">
                                        <div class="form-group">
                                            <label>Estado*</label>
                                            <select class="form-control select2" id="uf" name="uf" required data-placeholder="Estado">
                                                <option></option>
                                                @forelse(uf_list() as $key=>$value)
                                                    <option value="{{$key}}" {{(optional($occurrence->occurrence_client)->uf==$key?"selected":"")}}>{{$value}} ({{$key}})</option>
                                                @empty
                                                @endforelse
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="complement">Complemento</label>
                                            <input type="text" class="form-control" id="complement" name="complement"
                                                   value="{{ (old('complement'))? old('complement') : optional($occurrence->occurrence_client)->complement}}" autocomplete="off"
                                                   placeholder="Complemento">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="reference">Referência</label>
                                            <input type="text" class="form-control" id="reference" name="reference"
                                                   value="{{ (old('reference'))? old('reference') : optional($occurrence->occurrence_client)->reference}}" autocomplete="off"
                                                   placeholder="Referência">
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
</div>
