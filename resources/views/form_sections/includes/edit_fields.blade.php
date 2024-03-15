@if($form_section->form_fields->count())
<div class="sortable">
    @foreach($form_section->form_fields as $form_field)
    <div id="{{$form_field->id}}">

            <div class="row">
                <input type="hidden" readonly="" class="form-control" name="item_id[]" value="{{$form_field->id}}"
                       placeholder="Nome" autocomplete="off">

                <div class="form-group  col-md-3" id="nameItem">
                    <i class="bx bx-move-vertical grabbable"></i>
                    <label for="name">Nome</label>
                    <input type="text" class="form-control" name="nameItem[]" value="{{$form_field->name}}"
                           placeholder="Nome" autocomplete="off">
                </div>

                <div class="form-group  col-md-3">
                    <label for="name">Descrição</label>
                    <input type="text" class="form-control" name="descriptionItem[]" value="{{$form_field->description}}"
                           placeholder="Nome" autocomplete="off">
                </div>

                <div class="form-group  col-md-2">
                    <label for="name">Tipo</label>
                    <select class="form-control select2 typeFieldItemEdit" name="typeFieldItemId[]"
                            data-id="{{$form_field->id}}" data-placeholder="Tipo Formulário">

                    <option value="2" @if($form_field->type_field == 2) selected="selected" @endif>Texto</option>
                    <option value="1" @if($form_field->type_field == 1) selected="selected" @endif>Checkbox</option>
                    <option value="3" @if($form_field->type_field == 3) selected="selected" @endif>Radio</option>
                    <option value="4" @if($form_field->type_field == 4) selected="selected" @endif>Numérico</option>
                    <option value="5" @if($form_field->type_field == 5) selected="selected" @endif>Imagem</option>
                    <option value="6" @if($form_field->type_field == 6) selected="selected" @endif>Seleção</option>
                    <option value="7" @if($form_field->type_field == 7) selected="selected" @endif>Assinatura</option>
                </select>
            </div>

                <div class="form-group  col-md-1">
                    <label for="name">Obrigatório?</label>
                    <select class="form-control select2" name="requiredItemId[]" data-id="{{$form_field->id}}"
                            data-placeholder="Tipo Formulário">
                        <option value="2" @if($form_field->required == 2) selected="selected" @endif>Não</option>
                        <option value="1" @if($form_field->required == 1) selected="selected" @endif>Sim</option>
                    </select>
                </div>

                <div class="form-group  col-md-2">
                    <label>Min. fotos obrigatórias</label>
                    <select class="form-control select2" name="picAmount[]" data-id="{{$form_field->min_photo}}"
                            data-placeholder="Quantidade mínima de fotos">
                        <option></option>
                        <option value="0" @if($form_field->min_photo == 0) selected="selected" @endif>Nenhuma</option>
                        <option value="1" @if($form_field->min_photo == 1) selected="selected" @endif>1+</option>
                        <option value="2" @if($form_field->min_photo == 2) selected="selected" @endif>2+</option>
                        <option value="3" @if($form_field->min_photo == 3) selected="selected" @endif>3+</option>
                    </select>
                </div>

                <div class="form-group  col-md-1">
                    <label>&nbsp;</label>
                    <div>
                    <span class="btn btn-danger" id="removeItem" title="Remover" onclick="removeItem(this)"><i
                            class="bx bx-minus"></i> </span>
                    </div>
                </div>

                <input type="hidden" name="lists_answers[]" id="answer_{{$form_field->id}}" value="{{$form_field->list}}">
                <div class="form-group  col-md-12">
                    @php
                        $questions = [];
                        if($form_field->list) {
                            $questions = array_filter(explode(";", $form_field->list));

                        }
                    @endphp
                    <div class="row" id="radioOptions_{{$form_field->id}}"
                         @if($form_field->type_field != 3 && $form_field->type_field != 1 && $form_field->type_field != 6) style="display: none" @endif>
                        <div class="form-group  col-md-6">

                            <label for="name">Adicionar Resposta</label>
                            <input type="text" class="form-control " id="respostaItem_{{$form_field->id}}"
                                   name="respostaItem" placeholder="Resposta" autocomplete="off">
                        </div>
                        <div class="form-group  col-md-1">
                            <label>&nbsp;</label>
                            <div>
                                <button type="button" class="btn btn-success addRespostaEdit" data-id="{{$form_field->id}}"
                                        title="Adicionar"><i class="bx bx-plus"></i></button>
                            </div>
                        </div>
                    </div>
                    <div id="listOptions_{{$form_field->id}}"
                         @if($form_field->type_field != 3 && $form_field->type_field != 1 && $form_field->type_field != 6) style="display: none" @endif>
                        <div><b>Respostas: </b></div>

                        @foreach($questions as $question)
                            <div class="row">
                                <div class="form-group  col-md-6" id="nameItem">
                                    <label for="name">&nbsp;</label>
                                    <input type="text" readonly class="form-control respostaItem_{{$form_field->id}}"
                                           name="respostas" value="{{$question}}">
                                </div>

                                <div class="form-group  col-md-1">
                                    <label>&nbsp;</label>
                                    <div>
                                    <span class="btn btn-danger" id="removeItemOption" title="Remover"
                                          onclick="removeItemOption(this, {{$form_field->id}})"><i
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
