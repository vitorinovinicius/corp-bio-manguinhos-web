<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="box-title">Dados do formulário</h3>
            </div>
            <div class="card-content">
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="name">Nome</label>
                                <p class="form-control-static" >{{$form->name}}</p>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="name">Status</label>
                                <p class="form-control-static" >{{ativo_inativo($form->status)}}</p>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group">
                                <label for="name">Descrição</label>
                                <div class="form-control-static" >{!! $form->description !!}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
