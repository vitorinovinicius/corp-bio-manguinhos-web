@if($ticketTypeSection->ticketTypeSectionFields->count())
<div class="sortable">
    @foreach($ticketTypeSection->ticketTypeSectionFields as $field)
    <div id="{{$field->id}}">

            <div class="row">
                <input type="hidden" readonly="" class="form-control" name="item_id[]" value="{{$field->id}}"
                       placeholder="Nome" autocomplete="off">

                <div class="form-group  col-md-3" id="nameItem">
                    <i class="bx bx-move-vertical grabbable"></i>
                    <label for="name">Nome</label>
                    <input type="text" class="form-control" name="nameItem[]" value="{{$field->name}}"
                           placeholder="Nome" autocomplete="off">
                </div>

                <div class="form-group  col-md-3">
                    <label for="name">Descrição</label>
                    <input type="text" class="form-control" name="descriptionItem[]" value="{{$field->description}}"
                           placeholder="Nome" autocomplete="off">
                </div>

                <div class="form-group  col-md-2">
                    <label for="name">Tipo</label>
                    <select class="form-control select2 typeFieldItemEdit" name="typeFieldItemId[]"
                            data-id="{{$field->id}}" data-placeholder="Tipo Formulário">

                    <option value="2" @if($field->type_field == 2) selected="selected" @endif>Texto</option>
                    <option value="1" @if($field->type_field == 1) selected="selected" @endif>Checkbox</option>
                    <option value="3" @if($field->type_field == 3) selected="selected" @endif>Radio</option>
                    <option value="4" @if($field->type_field == 4) selected="selected" @endif>Numérico</option>
                    <option value="5" @if($field->type_field == 5) selected="selected" @endif>Imagem</option>
                    <option value="6" @if($field->type_field == 6) selected="selected" @endif>Seleção</option>
                    <option value="7" @if($field->type_field == 7) selected="selected" @endif>Assinatura</option>
                </select>
            </div>

                <div class="form-group  col-md-1">
                    <label for="name">Obrigatório?</label>
                    <select class="form-control select2" name="requiredItemId[]" data-id="{{$field->id}}"
                            data-placeholder="Tipo Formulário">
                        <option value="2" @if($field->required == 2) selected="selected" @endif>Não</option>
                        <option value="1" @if($field->required == 1) selected="selected" @endif>Sim</option>
                    </select>
                </div>

                <div class="form-group  col-md-2">
                    <label>Min. fotos obrigatórias</label>
                    <select class="form-control select2" name="picAmount[]" data-id="{{$field->min_photo}}"
                            data-placeholder="Quantidade mínima de fotos">
                        <option></option>
                        <option value="0" @if($field->min_photo == 0) selected="selected" @endif>Nenhuma</option>
                        <option value="1" @if($field->min_photo == 1) selected="selected" @endif>1+</option>
                        <option value="2" @if($field->min_photo == 2) selected="selected" @endif>2+</option>
                        <option value="3" @if($field->min_photo == 3) selected="selected" @endif>3+</option>
                    </select>
                </div>

                <div class="form-group  col-md-1">
                    <label>&nbsp;</label>
                    <div>
                    <span class="btn btn-danger" id="removeItem" title="Remover" onclick="removeItem(this)"><i
                            class="bx bx-minus"></i> </span>
                    </div>
                </div>

                <input type="hidden" name="lists_answers[]" id="answer_{{$field->id}}" value="{{$field->list}}">
                <div class="form-group  col-md-12">
                    @php
                        $questions = [];
                        if($field->list) {
                            $questions = array_filter(explode(";", $field->list));

                        }
                    @endphp
                    <div class="row" id="radioOptions_{{$field->id}}"
                         @if($field->type_field != 3 && $field->type_field != 1 && $field->type_field != 6) style="display: none" @endif>
                        <div class="form-group  col-md-6">

                            <label for="name">Adicionar Resposta</label>
                            <input type="text" class="form-control " id="respostaItem_{{$field->id}}"
                                   name="respostaItem" placeholder="Resposta" autocomplete="off">
                        </div>
                        <div class="form-group  col-md-1">
                            <label>&nbsp;</label>
                            <div>
                                <button type="button" class="btn btn-success addRespostaEdit" data-id="{{$field->id}}"
                                        title="Adicionar"><i class="bx bx-plus"></i></button>
                            </div>
                        </div>
                    </div>
                    <div id="listOptions_{{$field->id}}"
                         @if($field->type_field != 3 && $field->type_field != 1 && $field->type_field != 6) style="display: none" @endif>
                        <div><b>Respostas: </b></div>

                        @foreach($questions as $question)
                            <div class="row">
                                <div class="form-group  col-md-6" id="nameItem">
                                    <label for="name">&nbsp;</label>
                                    <input type="text" readonly class="form-control respostaItem_{{$field->id}}"
                                           name="respostas" value="{{$question}}">
                                </div>

                                <div class="form-group  col-md-1">
                                    <label>&nbsp;</label>
                                    <div>
                                    <span class="btn btn-danger" id="removeItemOption" title="Remover"
                                          onclick="removeItemOption(this, {{$field->id}})"><i
                                            class="bx bx-minus"></i> </span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

            </div>
            <hr>
    </div>
    @endforeach
</div>
@endif
