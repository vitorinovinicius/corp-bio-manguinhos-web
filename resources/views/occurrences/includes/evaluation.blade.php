@if($occurrence->model_evaluation)
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="box-title">Avaliação do cliente</h3>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="name">Nota</label>
                                    <p class="form-control-static">{{ optional($occurrence->model_evaluation)->rate}}</p>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="name">Comentário</label>
                                    <p class="form-control-static">{!! optional($occurrence->model_evaluation)->comment !!}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
