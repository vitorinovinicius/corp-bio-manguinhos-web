@if($occurrence->status == 2 || $occurrence->status == 3 || $occurrence->moves->count() > 0)

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="box-title">Dados da Localização ao iniciar e finalizar a OS</h3>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <!-- Dados do Mapa -->
                        @if($occurrence->status == 2 || $occurrence->status == 3)
                            {{-- MAPA E CHECKIN--}}
                            @include("occurrences.includes.dados_mapa")
                        @endif

                        <!-- Dados de Movimentação -->
                        @if($occurrence->moves->count())
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="box-title">Dados de Movimentação</h3>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        {{-- MAPA E CHECKIN--}}
                                        @include('occurrences.includes.moves')
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
