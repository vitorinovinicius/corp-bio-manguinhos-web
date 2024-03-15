<div class="card">
    <div class="card-header">
        <h3 class="box-title"><i class="bx bx-list-plus"></i>Adicionar Campos</h3>
    </div>
    <div class="card-content">
        <div class="card-body">
            <div class="row">
                <div class="col-2">
                    <div class="form-group">
                        <label>Nome</label>
                        <input type="text" class="form-control" id="nameItem"  name="nameItem" placeholder="Nome" autocomplete="off">
                    </div>
                </div>
                <div class="col-2">
                    <div class="form-group">
                        <label>Descrição</label>
                        <input type="text" class="form-control" id="descriptionItem" name="descriptionItem" placeholder="Nome" autocomplete="off">
                    </div>
                </div>
                <div class="col-2">
                    <div class="form-group">
                        <label>Tipo</label>
                        <select class="form-control select2" name="typeFieldItem"  id="typeFieldItem" data-placeholder="Tipo Formulário" >
                            <option></option>
                            <option value="2" >Texto</option>
                            <option value="1" >Checkbox</option>
                            <option value="3" >Radio</option>
                            <option value="4" >Numérico</option>
                            <option value="5" >Imagem</option>
                            <option value="6" >Seleção</option>
                            <option value="7" >Assinatura</option>
                        </select>
                    </div>
                </div>
                <div class="col-2">
                    <div class="form-group">
                        <label>Obrigatório</label>
                        <select class="form-control select2" name="requiredItem" id="requiredItem" data-placeholder="Escolha" >
                            <option></option>
                            <option value="2">Não</option>
                            <option value="1">Sim</option>
                        </select>
                    </div>
                </div>
                <div class="col-2">
                    <div class="form-group">
                        <label>Min. fotos obrigatórias</label>
                        <select class="form-control select2" name="picAmount"  id="picAmount" data-placeholder="Quantidade mínima de fotos" >
                            <option></option>
                            <option value="0" >Nenhuma</option>
                            <option value="1" >1+</option>
                            <option value="2" >2+</option>
                            <option value="3" >3+</option>
                        </select>
                    </div>
                </div>
                <div class="col-2">
                    <div class="form-group">
                        <br>
                        <button style="white-space: inherit" class="btn btn-success" id="addItem" title="Adicionar"><i class="bx bx-plus"></i> Adicionar Campo </button>
                    </div>
                </div>
            </div>
            <div id="answers-container">
                <div class="row" id="radioOptions" style="display: none">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="name">Adicionar Resposta</label>
                            <input type="text" class="form-control"  id="respostaItem" name="respostaItem" placeholder="Resposta" autocomplete="off">
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <br>
                            <button class="btn btn-success" id="addResposta" title="Adicionar"><i class="bx bx-plus"></i> Adicionar</button>
                        </div>
                    </div>
                </div>
                <div id="listOptions" style="display: none">
                    <div id="respostaLabel" style="display: none"> <b>Respostas: </b></div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3 class="box-title"><i class="bx bx-list-ul"></i>Lista de Campos Adicionados</h3>
    </div>
    <div class="card-content">
        <div class="card-body">
            <div id="listItens">
                @if($edit)
                    @include("form_sections.includes.edit_fields")
                @endif
            </div>
        </div>
    </div>
</div>
