<div class="card">
    <div class="card-header">
        <h3 class="box-title">Dados complementares do cliente no momento do atendimento</h3>
        <a class="heading-elements-toggle">
            <i class="bx bx-dots-vertical font-medium-3"></i>
        </a>
        <div class="heading-elements">
            <ul class="list-inline mb-0">
                <li>
                    <a data-action="collapse" class="rotate">
                        <i class="bx bx-chevron-down"></i>
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <div class="card-content collapse show">
        <div class="card-body">
            <div class="row">
                <div class="col-3">
                    <div class="form-group">
                        <label for="name" >Tipo</label>
                        <select name="cliente[cliente_tipo]" id="cliente_acompanha" class="form-control">
                            <option></option>
                            <option value="1">Outros</option>
                            <option value="2">Proprio</option>
                        </select>                        
                    </div>
                </div>
                
                <div class="col-3">
                    <div class="form-group">
                        <label for="name">Tipo - Outros</label>
                        <input name="cliente[cliente_tipo_outros]" id="outros" type="text" class="form-control">                            
                    </div>
                </div>
               
                <div class="col-6">
                    <div class="form-group">
                        <label for="name">Nome</label>
                        <input name="cliente[cliente_nome]" id="cliente_nome" type="text" class="form-control">                        
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <label for="name">E-mail</label>
                        <input name="cliente[cliente_email]" type="email" id="cliente_email" class="form-control">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-4">
                    <div class="form-group">
                        <label for="name">CPF</label>
                        <input name="cliente[cliente_cpf]" type="text" id="cliente_cpf" class="form-control">                        
                    </div>
                </div>
                <div class="col-5">
                    <div class="form-group">
                        <label for="name">Telefone</label>
                        <input name="cliente[cliente_telefone]" type="text" id="cliente_telefone" class="form-control">                        
                    </div>
                </div>
                <div class="col-3">
                    <div class="form-group">
                        <label for="name">Quer receber por e-mail?</label>
                        <select name="cliente[cliente_recebe_email]" id="cliente_recebe_email" class="form-control">
                            <option></option>
                            <option value="0">Não</option>
                            <option value="1">Sim</option>
                        </select>                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>