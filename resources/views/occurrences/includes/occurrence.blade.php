<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="box-title">Dados da OS {{ $occurrence->numero_os }}</h3>
            </div>
            <div class="card-content">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="box-title">Detalhes da OS</h3>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <div class="row">
                                            @if($occurrence->numero_os)
                                                <div class="col-2">
                                                    <div class="form-group">
                                                        <label for="name">Número OS</label>
                                                        <h3>
                                                            <span class="btn btn-block btn-primary">{{ $occurrence->numero_os }}</span>
                                                        </h3>
                                                    </div>
                                                </div>
                                            @endif
                                            <div class="col-2">
                                                <div class="form-group">
                                                    <label for="name">Status da OS</label>
                                                    <h3 class="">
                                                        <span class='btn btn-block  {{$occurrence->statusLabel()}}'>{{$occurrence->getStatus()}}</span>
                                                    </h3>
                                                </div>
                                            </div>
                                            @if($occurrence->shift)
                                                <div class="col-2">
                                                    <div class="form-group">
                                                        <label for="name">Turno</label>
                                                        <h3 class="">
                                                            <span class='btn  btn-block btn-primary '>{{$occurrence->shift()}}</span>
                                                        </h3>
                                                    </div>
                                                </div>
                                            @endif
                                            <div class="col-2">
                                                <div class="form-group">
                                                    <label for="name">Prioridade</label>
                                                    <h3 class="">
                                                        <span class='btn  btn-block btn-primary '>{{$occurrence->priority()}}</span>
                                                    </h3>
                                                </div>
                                            </div>
                                            @if($occurrence->ticket_id)
                                                <div class="col-2">
                                                    <div class="form-group">
                                                        <label for="name">Ticket</label>
                                                        <h3 class="">
                                                            <span class='btn  btn-block btn-primary '>{{$occurrence->ticket_id}}</span>
                                                        </h3>
                                                    </div>
                                                </div>
                                            @endif
                                            @if($occurrence->status != 1)
                                                @if($occurrence->status_schedule != null)
                                                    <div class="col-2">
                                                        <div class="form-group">
                                                            <label for="schedule_type">Reagendado?</label>
                                                            <h3 class="onclick">
                                                                <span id="btnReagendar" class='btn btn-block {{ $occurrence->status_schedule == 2 ? "btn-primary" : "btn-danger" }}'>{{status_schedule($occurrence->status_schedule)}}</span>
                                                            </h3>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endif
                                            @if($occurrence->status == 2)
                                                <div class="col-2 hidden-pdf">
                                                    <div class="form-group">
                                                        <label for="name">Conclusão</label>
                                                        <h3 class="">
                                                            <span class='btn  btn-block {{ $occurrence->financialStatusLabel() }}'>{{$occurrence->financialStatus()}}</span>
                                                        </h3>
                                                    </div>
                                                </div>
                                            @endif
                                            {{--                                                <div class="col-2">--}}
                                            {{--                                                    <div class="form-group">--}}
                                            {{--                                                        <label for="name">Questionário COVID19</label>--}}
                                            {{--                                                        <h3 class="">--}}
                                            {{--                                                            <span class="btn  btn-block @if($occurrence->covid19_quest  == 1) btn-primary @else btn-danger @endif">--}}
                                            {{--                                                            {{ sim_nao($occurrence->covid19_quest) ? : "-" }}--}}
                                            {{--                                                            </span>--}}
                                            {{--                                                        </h3>--}}
                                            {{--                                                    </div>--}}
                                            {{--                                                </div>--}}
                                        </div>
                                        <div class="row">
                                            <div class="col-2" data-toggle="tooltip" title="Código de liberação para desbloquear OS no celular">
                                                <div class="form-group">
                                                    <label for="name">Senha</label>
                                                    <h3 class="">
                                                        <span class="btn  btn-block btn-primary">{{ $occurrence->code_verification? : "-" }}</span>
                                                    </h3>
                                                </div>
                                            </div>
                                            <div class="col-2 hidden-pdf" data-toggle="tooltip" title="Quantas vezes o cliente já foi visitado">
                                                <div class="form-group">
                                                    <label for="name">Visitas</label>
                                                    <h3 class="">
                                                        <span class="btn  btn-block btn-primary">{{ $occurrence->occurrence_client ? optional($occurrence->occurrence_client)->occurrences->where('contractor_id', $occurrence->contractor_id)->count() : "-"}}</span>
                                                    </h3>
                                                </div>
                                            </div>
                                            <div class="col-2 hidden-pdf">
                                                <div class="form-group">
                                                    <label for="name">Alertas</label>
                                                    <h3 class="">
                                                        <span class="btn  btn-block btn-primary">
                                                        {{ $occurrence->alerts->count() }}
                                                        </span>
                                                    </h3>
                                                </div>
                                            </div>
                                            <div class="col-2">
                                                <div class="form-group">
                                                    <label for="name">SMS</label>
                                                    <h3 class="">
                                                        <span class="btn btn-block @if($occurrence->status_sms == 1) btn-primary @else btn-danger @endif">
                                                            {{ $occurrence->status_sms() }}
                                                        </span>
                                                    </h3>
                                                </div>
                                            </div>

                                            <div class="col-2">
                                                <div class="form-group">
                                                    <label for="name">Fotos</label>
                                                    <h3>
                                                        <span class="btn btn-block btn-primary">{{ $occurrence->occurrence_images->count() }} de {{ $occurrence->total_imagens?: '-' }}</span>
                                                    </h3>
                                                </div>
                                            </div>
                                            @if($occurrence->manual_execution == 1)
                                                <div class="col-2 hidden-pdf">
                                                    <div class="form-group">
                                                        <label for="name">Executada manualmente</label>
                                                        <h3>
                                                            <span class='btn btn-block btn-warning'>Sim</span>
                                                        </h3>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="row">
                                            <div class="col-4">
                                                <div class="form-group">
                                                    <label for="name">Nome da Ocorrência</label>
                                                    <p class="form-control-static">{{optional($occurrence->occurrence_type)->name}}</p>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="form-group">
                                                    <label for="name">Técnico</label>
                                                    <p class="form-control-static">
                                                        @if(isset($occurrence->operator))
                                                            {{$occurrence->operator_id}} - {{$occurrence->operator->name}}
                                                        @else
                                                            Sem técnico associado
                                                        @endif
                                                    </p>
                                                </div>
                                            </div>

                                            @is('superuser','regiao')
                                            <div class="col-4">
                                                <div class="form-group">
                                                    <label for="name">Empreiteira</label>
                                                    <p class="form-control-static">{!! optional($occurrence->contractor)->name !!}</p>
                                                </div>
                                            </div>
                                            @endis
                                            @if($occurrence->manual_execution == 1)
                                                <div class="col-4 hidden-pdf">
                                                    <div class="form-group">
                                                        <label for="name">Executada por</label>
                                                        <p class='form-control-static'>{{optional($occurrence->executeBy)->name}}</p>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="row">
                                            <div class="col-2 hidden-pdf">
                                                <div class="form-group">
                                                    <label for="name">Inserido em</label>
                                                    <p class="form-control-static">{{(!empty($occurrence->created_at) > 0 ? date('d/m/Y H:i', strtotime($occurrence->created_at)) : "-")}}</p>
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <div class="form-group">
                                                    <label for="name">Agendado</label>
                                                    <p class="form-control-static">{{$occurrence->dataAgendamentoFormart()}}</p>
                                                </div>
                                            </div>
                                            <div class="col-2 hidden-pdf">
                                                <div class="form-group">
                                                    <label for="name">Recebido no celular</label>
                                                    <p class="form-control-static">{{(!empty($occurrence->download_at) ? date('d/m/Y H:i', strtotime($occurrence->download_at)) : "-")}}</p>
                                                </div>
                                            </div>
                                            <div class="col-2 hidden-pdf">
                                                <div class="form-group">
                                                    <label for="name">Recebido no sistema</label>
                                                    <p class="form-control-static">{{(!empty($occurrence->date_finish) ? date('d/m/Y H:i:s', strtotime($occurrence->date_finish)) : "-")}}</p>
                                                </div>
                                            </div>
                                            <div class="col-2 hidden-pdf">
                                                <div class="form-group">
                                                    <label for="name">Data Aprovado</label>
                                                    <p class="form-control-static">{{(!empty($occurrence->approved_date) > 0 ? date('d/m/Y H:i', strtotime($occurrence->approved_date)) : "-")}}</p>
                                                </div>
                                            </div>
                                        </div>
                                        @if($occurrence->ticket_id != null)
                                            <div class="row hidden-pdf">
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label for="name">Dados do Ticket</label>
                                                        <p class="form-control-static">{!! $occurrence->obs_os !!}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        @if($dataForms != '')
                                            @foreach ($dataForms as $formSections)                                                
                                                @if(isset($formSections["form_fields"]))
                                                    @foreach($formSections["form_fields"] as $field)
                                                        @if($field['type_field'] == 5 || $field['type_field'] == 7)                                                                    
                                                            @if(isset($field["value"]) && !empty($field["value"]))
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <label for="">Fotos do ticket</label>
                                                                    </div>
                                                                    <div class="col-2 text-center">
                                                                        <img src="{{$field["value"]}}"
                                                                            style="display: block; max-width: 100%; height:auto;"
                                                                            class="img-responsive cursor-pointer open-modal-img"
                                                                            id="image-rotate-{{$field["value"]}}" data-toggle="modal" data-target="#imgModal"
                                                                            data-image="{{$field["value"]}}">
                                                                        <div class="hidden-pdf">
                                                                            <a href="{{$field["value"]}}" class="btn btn-link" target="_blank">
                                                                                Abrir externamente
                                                                                <i class="bx bx-share"></i>
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        @endif                                                                
                                                    @endforeach
                                                @endif                                    
                                                            
                                            @endforeach
                                        @endif
                                        <div class="row hidden-pdf">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="name">Observações da empresa</label>
                                                    <p class="form-control-static">{!! $occurrence->obs_empreiteira !!}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row hidden-pdf">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="box-title">Formulários da OS</h3>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <h4>Formulários enviados para o celular</h4>
                                            </div>
                                        </div>
                                        <div class="row">
                                            @foreach(optional($occurrence->occurrence_type)->forms()->orderBy("occurrence_type_forms.id","asc")->get() as $form)

                                                <div class="col-4">
                                                    <div class="form-group d-flex">
                                                        <p class="form-control input-static">{{$form->name}}</p>
                                                        <div class="dropdown ml-1">
                                                            <button type="button" class="btn btn-outline-primary btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                <i class="bx bxs-file-pdf"></i>
                                                            </button>
                                                            <div class="dropdown-menu" style="">
                                                              <a class="dropdown-item" href="{{route('admin.occurrences.pdfGenerate',[$occurrence->uuid, ' ', $form->id])}}">PDF com imagem</a>
                                                              <a class="dropdown-item" href="{{route('admin.occurrences.pdfGenerate',[$occurrence->uuid, 1, $form->id])}}">PDF sem imagem</a>
                                                            </div>
                                                          </div>
                                                        {{-- <a type="button" href="{{route('admin.occurrences.pdfGenerate',[$occurrence->uuid,'',$form->id])}}" class="btn btn-icon btn-outline-primary ml-1 mr-1 mb-1" title="Download pdf"><i class="bx bxs-file-pdf"></i></a> --}}
                                                    </div>
                                                </div>
                                            @endforeach
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
