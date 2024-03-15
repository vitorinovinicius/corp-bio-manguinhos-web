<div class="modal fade" id="modal-information">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Informações da OS</h4>
            </div>
            <div class="modal-body col-md-12">

                <div class="form-group col-md-12">
                    <label>Nome da OS</label>
                    <div class="input-static" id="modal-nome-os"></div>
                </div>
                <div class="form-group col-md-12">
                    <label>Observação geral</label>
                    <div class="input-static" id="modal-obs-empreiteira" style="white-space: pre-wrap">-</div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-right" data-dismiss="modal">Fechar</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

@section('scripts_extra')
    <script nonce="{{ csp_nonce() }}">
        $(function () {
            $(".btn-information").on("click", function () {
                $("#modal-nome-os").text($(this).data("nomeOs"));
                $("#modal-obs-empreiteira").text($(this).data("obsEmpreiteira"));
            });
        });
    </script>
@endsection