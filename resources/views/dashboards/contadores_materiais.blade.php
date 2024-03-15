<div class="box box-solid box-danger box_contador">
    <div class="box-header">
        <h3 class="box-title">Monitoramento das Ocorrências do dia</h3>
        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse">
                <i class="bx bx-minus"></i></button>
        </div>
    </div>
    <div class="box-body padding-bottom-0">
        <div class="col-md-12 padding-0">

            <div class="col-md-3 padding-5 padding-tb-5">
                <!-- Apply any bg-* class to to the info-box to color it -->
                <div class="info-box bg-aqua">
                    <span class="info-box-icon box_total_value">0</span>
                    <div class="info-box-content">
                        <span class="info-box-text padding-bottom-10">Total Geral</span>
                        <!-- The progress section is optional -->
                        <div class="progress">
                            <div class="progress-bar box_total_progress"></div>
                        </div>
                    </div><!-- /.info-box-content -->
                </div><!-- /.info-box -->
            </div>

            <div class="col-md-3 padding-5 padding-tb-5">
                <!-- Apply any bg-* class to to the info-box to color it -->
                <div class="info-box bg-green">
                    <span class="info-box-icon box_total_pecas">0</span>
                    <div class="info-box-content">
                        <span class="info-box-text padding-bottom-10">Peças</span>
                        <!-- The progress section is optional -->
                        <div class="progress">
                            <div class="progress-bar padding-bottom box_realized_progress"></div>
                        </div>
                    </div><!-- /.info-box-content -->
                </div><!-- /.info-box -->
            </div>
            <div class="col-md-3 padding-5 padding-tb-5">
                <!-- Apply any bg-* class to to the info-box to color it -->
                <div class="info-box bg-red">
                    <span class="info-box-icon box_total_servicos">0</span>
                    <div class="info-box-content">
                        <span class="info-box-text padding-bottom-10">Serviços</span>
                        <!-- The progress section is optional -->
                        <div class="progress">
                            <div class="progress-bar padding-bottom box_unsolved_progress"></div>
                        </div>
                    </div><!-- /.info-box-content -->
                </div><!-- /.info-box -->
            </div>
            <div class="col-md-3 padding-5 padding-tb-5">
                <!-- Apply any bg-* class to to the info-box to color it -->
                <div class="info-box bg-yellow">
                    <span class="info-box-icon box_total_equipamentos">0</span>
                    <div class="info-box-content">
                        <span class="info-box-text padding-bottom-10">Equipamentos</span>
                        <!-- The progress section is optional -->
                        <div class="progress">
                            <div class="progress-bar padding-bottom box_pending_progress"></div>
                        </div>
                    </div><!-- /.info-box-content -->
                </div><!-- /.info-box -->
            </div>

        </div>


    </div>
</div>

@section('scripts_extra')
    <script nonce="{{ csp_nonce() }}">
        $(function () {
            function contadores() {
                $.ajax({
                    type: 'GET',
                    url: '{!! route('admin.dashboard.ajax_materiais',request()->all()) !!}',
                    beforeSend: function () {
                        $(".box_contador").append('<div class="overlay"><i class="bx bx-refresh fa-spin"></i></div>');
                    },
                    success: function (data) {
                        $(".box_total_value").text(data.schedules_all.total);

                        $(".box_total_pecas").text(data.schedules_pecas.total);

                        $(".box_total_servicos").text(data.schedules_servicos.total);

                        $(".box_total_equipamentos").text(data.schedules_equipamentos.total);

                        $(".overlay").fadeOut();

                    },
                    error: function () {
                        $(".overlay").fadeOut();
                        console.log("Ocorreu um erro inesperado durante o processamento.\nRecarregue a página e tente novamente");
                    }
                });
            }

            contadores();
            setInterval(function () {
                contadores();
            }, 1 * 60 * 1000);
        });

    </script>
@endsection
