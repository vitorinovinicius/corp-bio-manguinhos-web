{{-- Start add modal --}}
<div class="modal fade" id="storeModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="storeModal">Adicionar seção</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="storeSecao">
                @csrf
                <input type="hidden" name="formulario_id">
                <div class="modal-body">
                    <div class="form-body">
                        <div class="col-2">
                            <label for="principal">Tipo seção</label>
                            <div class="form-group">
                                <div class="form-group form-check form-check-inline">
                                    <input type="radio" name="tipo" value="1" class="form-check-input" id="titulo" checked>
                                    <label class="form-check-label" for="titulo">Titulo</label>                                                        
                                </div>
                                <div class="form-group form-check form-check-inline">
                                    <input type="radio" name="tipo" value="2" class="form-check-input" id="sub-titulo">
                                    <label class="form-check-label" for="sub-titulo">Sub-titulo</label>                                                        
                                </div>
                            </div>
                        </div>

                        <div id="titulo-selection">
                            <div class="form-group">                                
                                @if(isset($titulos) || isset($subTitulos))
                                <label for="existing-titulos">Selecione um título existente</label>
                                <select class="form-control" id="existing-titulos" name="secao_id">
                                    <option value="">Selecione um título</option>
                                        @foreach($titulos as $titulo)
                                            <option value="{{ $titulo->id }}">{{ $titulo->descricao }}</option>
                                        @endforeach
                                </select>
                                @endif
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-8">
                                <div class="form-group">
                                    <label>Descrição</label>
                                    <input type="text" class="form-control" name="descricao" value="{{ old('descricao') }}" placeholder="Insira o nome do titulo ou sub-titulo" autocomplete="off" required>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Limite de caracteres</label>
                                    <input type="number" class="form-control" name="limite_caracteres" value="{{ old('limite_caractere') }}" placeholder="Digite o limite de caracteres" autocomplete="off" required>
                                </div>
                            </div>                                    
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Setor responsável</label>
                                    <select class="form-control" name="setor_id" data-placeholder="Setor responsável pelo preenchimento">
                                        @foreach($teams as $setor)
                                        <option value="{{$setor->id}}">{{$setor->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                    <button id="submitStore" class="btn btn-primary">Salvar</button>
                </div>
            </form>
        </div>
    </div>
</div>
{{-- End add modal --}}