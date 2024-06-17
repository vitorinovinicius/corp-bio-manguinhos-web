{{-- Start add modal --}}
<div class="modal fade" id="storeImagemModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="storeImagemModal">Adicionar imagem</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="storeImagem" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="secao_formulario_id">
                <div class="modal-body">
                    <div class="form-body">
                        <div class="col-2">
                            <label for="principal">Tipo imagem</label>
                            <div class="form-group">
                                <div class="form-group form-check form-check-inline">
                                    <input type="radio" name="tipo_imagem" value="1" class="form-check-input" id="titulo" checked>
                                    <label class="form-check-label" for="titulo">Figura</label>                                                        
                                </div>
                                <div class="form-group form-check form-check-inline">
                                    <input type="radio" name="tipo_imagem" value="2" class="form-check-input" id="sub-titulo">
                                    <label class="form-check-label" for="sub-titulo">Gráfico</label>                                                        
                                </div>
                                <div class="form-group form-check form-check-inline">
                                    <input type="radio" name="tipo_imagem" value="3" class="form-check-input" id="sub-titulo">
                                    <label class="form-check-label" for="sub-titulo">Tabela</label>                                                        
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Legenda</label>
                                    <input type="text" class="form-control" name="legenda">
                                </div>
                            </div>
                            <div class="col-8">
                                <div class="form-group">
                                    <label for="imagens">Imagem</label>
                                    <input type="file" name="imagens" class="form-control-file" id="imagens">
                                </div>
                            </div>                                    
                        </div>
                    </div>                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                    <button id="submitImagem" class="btn btn-primary">Salvar</button>
                </div>
            </form>
        </div>
    </div>
</div>
{{-- End add modal --}}
