<div class="row">
    <div class="col-12">
        <form class="form form-vertical" action="{{ route('occurrences.store') }}" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="ticket_id" value="{{ $dataTicket->id }}">
            <input type="hidden" name="occurrence_client_id" value="{{ $client->id }}">
            <div class="form-body">
                <div class="row">
                    <div class="col-12">
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
                                                <input type="text" autocomplete="off" class="form-control" id="numero_os" name="numero_os" value="{{ old('numero_os') }}" placeholder="Número OS">
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="form-group">
                                                <label>Data do agendamento*</label>
                                                <input type="text" autocomplete="off" class="form-control date-picker" id="schedule_date" name="schedule_date" value="{{ old('schedule_date') }}" placeholder="Data do agendamento" required>
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <div class="form-group">
                                                <label>Hora do agendamento</label>
                                                <input type="time" autocomplete="off" class="form-control" id="schedule_time" name="schedule_time" value="{{ old('schedule_time') }}" placeholder="Hora do agendamento">
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <div class="form-group">
                                                <label>Turno</label>
                                                <select class="form-control select2" name="shift" data-placeholder="Turno">
                                                    <option></option>
                                                    <option value="1" {{(old('shift')==1?"selected":"")}}>Manhã</option>
                                                    <option value="2" {{(old('shift')==2?"selected":"")}}>Tarde</option>
                                                    <option value="3" {{(old('shift')==3?"selected":"")}}>Noite</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="form-group">
                                                <label>Prioridade*</label>
                                                <select class="form-control select2" name="priority" required data-placeholder="Prioridade">
                                                    <option></option>
                                                    @forelse(priority_list_array() as $key=>$value)
                                                        <option value="{{$key}}" {{(old('priority')==$key?"selected":"")}}>{{$value}}</option>
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

                                        <div class="col-12">
                                            <div class="form-group">
                                                <label>Tipo da Ocorrência*</label>
                                                <select class="form-control select2" name="occurrence_type_id" data-placeholder="Selecione o tipo da Ocorrência">
                                                    <option></option>
                                                    @forelse($occurrence_types as $ot)
                                                        <option value="{{$ot->id}}" {{(old('occurrence_type_id')==$ot->id?"selected":"")}}>{{$ot->name}}</option>
                                                    @empty
                                                    @endforelse
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="form-group">
                                                <label>Atribuir para:
                                                    <span class="text-danger text-sm"> Não obrigatório </span></label>
                                                <select class="form-control select2" name="operator_id" data-placeholder="Escolha um Operador">
                                                    <option></option>
                                                    @forelse($operators as $operator)
                                                        <option
                                                            value="{{$operator->id}}" {{(old('operator_id')==$operator->id?"selected":"")}}
                                                        @if(isset($operador) && ($operator->id == $operador->id)) selected @endif
                                                        >{{$operator->name}}</option>
                                                    @empty
                                                    @endforelse
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="form-group">
                                                <label>Observação</label>
                                                <textarea rows="7" class="form-control" id="obs_empreiteira" name="obs_empreiteira" placeholder="Observação da Ocorrência">{{ $dataTicket->description }}</textarea>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="form-group">
                                                <label>Anexo</label>
                                                <input type="file" class="form-control" name="anexos[]" id="anexo" multiple>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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
                                                <input type="text" autocomplete="off" class="form-control" id="client_name" name="name" value="{{ $client->name }}" placeholder="Nome completo do cliente" required>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="form-group">
                                                <label>Número externo do cliente</label>
                                                <input type="text" autocomplete="off" class="form-control" id="client_number" name="client_number" value="{{ $client->client_number }}" placeholder="Nº cliente">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-4">
                                            <div class="form-group">
                                                <label>E-mail</label>
                                                <input type="email" class="form-control" id="email" name="email" value="{{ $client->email }}" placeholder="email">
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="form-group">
                                                <label>CPF ou CNPJ</label>
                                                <input type="text" autocomplete="off" class="form-control" id="cpf_cnpj" name="cpf_cnpj" value="{{ $client->cpf_cnpj }}" placeholder="CPF ou CNPJ">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="divPhonePrincipal">
                                    </div>
                                    <div class="row">
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
                                                    <input type="text" autocomplete="off" class="form-control" style="width: calc(100% - 95px);display: inline-block; margin-right: 6px;" id="cep" name="cep" value="{{ $client->cep }}" placeholder="CEP" required>
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
                                                <input type="text" autocomplete="off" class="form-control" id="address" name="address" value="{{ $client->address }}" placeholder="Endereço" required>
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <div class="form-group">
                                                <label for="number">Nº</label>
                                                <input type="text" class="form-control" id="number" name="number"
                                                       value="{{ $client->number }}" autocomplete="off" placeholder="Nº"
                                                       required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-5">
                                            <div class="form-group">
                                                <label>Bairro</label>
                                                <input type="text" autocomplete="off" class="form-control" id="district" name="district" value="{{ $client->district }}" placeholder="Bairro" required>
                                            </div>
                                        </div>
                                        <div class="col-5">
                                            <div class="form-group">
                                                <label>Cidade</label>
                                                <input type="text" autocomplete="off" class="form-control" id="city" name="city" value="{{ $client->city }}" placeholder="Cidade" required>
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <div class="form-group">
                                                <label>Estado*</label>
                                                <select class="form-control select2" id="uf" name="uf" required data-placeholder="Estado">
                                                    <option></option>
                                                    @forelse(uf_list() as $key=>$value)
                                                        <option value="{{$key}}" {{($client->uf==$key?"selected":"")}}>{{$value}} ({{$key}})</option>
                                                    @empty
                                                    @endforelse
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class='row'>
                                        <div class="col-5">
                                            <div class="form-group">
                                                <label for="zone">Zona</label>
                                                <select class="form-control select2" name="zone_id" data-placeholder="Selecione uma zona">
                                                    <option></option>
                                                    @forelse(\App\Models\Zone::all() as $zone)
                                                        <option value="{{$zone->id}}">{{$zone->zone}}</option>
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
                                                       value="{{ $client->complement }}" autocomplete="off"
                                                       placeholder="Complemento">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="reference">Referência</label>
                                                <input type="text" class="form-control" id="reference" name="reference"
                                                       value="{{ $client->reference }}" autocomplete="off"
                                                       placeholder="Referência">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 d-flex justify-content-end">
                                            <button type="submit" class="btn btn-primary">Criar</button>
                                            <a class="btn btn-link pull-right"
                                               href="{{ route('users.index') }}"><i
                                                    class="bx bx-arrow-back"></i> Voltar</a>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </form>
    </div>
</div>
