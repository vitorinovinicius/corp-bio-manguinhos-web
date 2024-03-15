
<div class="row">
    <div class="col-md-12">
        <h4>Contadores</h4>
    </div>
    <div class="col-md-2 padding-5 padding-tb-5">
        <div class="card text-center">
            <div class="card-content">
                <div class="card-body">
                    <div class="badge-circle badge-circle-lg badge-circle-light-info mx-auto my-1">
                        <i class="bx bx-file font-medium-5"></i>
                    </div>
                    <p class="text-muted mb-0 line-ellipsis">Alertas</p>
                    <h2 class="mb-0 box_total_os">{{$allAlert}}</h2>
                    <div class="progress progress-bar-info mb-1 mt-1">
                        <div class="progress-bar  progress-bar-animated box_total_progress"
                             role="progressbar" style="width:{{($allAlert>0)? number_format((float)($allAlert / $allAlert)*100, 2, '.', '') : "0"}}%"></div>
                    </div>
                    <span class="progress-description box_total_percent">{{($allAlert>0)? number_format((float)($allAlert / $allAlert)*100, 2, '.', '') : "0"}} % </span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-2 padding-5 padding-tb-5">
        <div class="card text-center">
            <div class="card-content">
                <div class="card-body">
                    <div class="badge-circle badge-circle-lg badge-circle-light-success mx-auto my-1">
                        <i class="bx bx-file font-medium-5"></i>
                    </div>
                    <p class="text-muted mb-0 line-ellipsis">OS em atraso</p>
                    <h2 class="mb-0 box_total_os">{{$totalOsAtraso}}</h2>
                    <div class="progress progress-bar-success mb-1 mt-1">
                        <div class="progress-bar  progress-bar-animated box_total_progress"
                             role="progressbar" style="width:{{($allAlert>0)? number_format((float)($totalOsAtraso / $allAlert)*100, 2, '.', '') : "0"}}%"></div>
                    </div>
                    <span class="progress-description box_total_percent">{{($allAlert>0)? number_format((float)($totalOsAtraso / $allAlert)*100, 2, '.', '') : "0"}} % </span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-2 padding-5 padding-tb-5">
        <div class="card text-center">
            <div class="card-content">
                <div class="card-body">
                    <div class="badge-circle badge-circle-lg badge-circle-light-danger mx-auto my-1">
                        <i class="bx bx-file font-medium-5"></i>
                    </div>
                    <p class="text-muted mb-0 line-ellipsis">OS com interferencia</p>
                    <h2 class="mb-0 box_total_os">{{$totalOsInterferencia}}</h2>
                    <div class="progress progress-bar-danger mb-1 mt-1">
                        <div class="progress-bar  progress-bar-animated box_total_progress"
                             role="progressbar" style="width:{{($allAlert>0)? number_format((float)($totalOsInterferencia / $allAlert)*100, 2, '.', '') : "0"}}%"></div>
                    </div>
                    <span class="progress-description box_total_percent">{{($allAlert>0)? number_format((float)($totalOsInterferencia / $allAlert)*100, 2, '.', '') : "0"}} % </span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-2 padding-5 padding-tb-5">
        <div class="card text-center">
            <div class="card-content">
                <div class="card-body">
                    <div class="badge-circle badge-circle-lg badge-circle-light-warning mx-auto my-1">
                        <i class="bx bx-file font-medium-5"></i>
                    </div>
                    <p class="text-muted mb-0 line-ellipsis">Equipamentos</p>
                    <h2 class="mb-0 box_total_os">{{$totalEquipamento}}</h2>
                    <div class="progress progress-bar-warning mb-1 mt-1">
                        <div class="progress-bar  progress-bar-animated box_total_progress"
                             role="progressbar" style="width:{{($allAlert>0)? number_format((float)($totalEquipamento / $allAlert)*100, 2, '.', '') : "0"}}%"></div>
                    </div>
                    <span class="progress-description box_total_percent">{{($allAlert>0)? number_format((float)($totalEquipamento / $allAlert)*100, 2, '.', '') : "0"}} % </span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-2 padding-5 padding-tb-5">
        <div class="card text-center">
            <div class="card-content">
                <div class="card-body">
                    <div class="badge-circle badge-circle-lg badge-circle-light-secondary mx-auto my-1">
                        <i class="bx bx-file font-medium-5"></i>
                    </div>
                    <p class="text-muted mb-0 line-ellipsis">Tempo médio atendimento</p>
                    <h2 class="mb-0 box_total_os">{{$totalTempoMedio}}</h2>
                    <div class="progress progress-bar-secondary mb-1 mt-1">
                        <div class="progress-bar  progress-bar-animated box_total_progress"
                             role="progressbar" style="width:{{($allAlert>0)? number_format((float)($totalTempoMedio / $allAlert)*100, 2, '.', '') : "0"}}%"></div>
                    </div>
                    <span class="progress-description box_total_percent">{{($allAlert>0)? number_format((float)($totalTempoMedio / $allAlert)*100, 2, '.', '') : "0"}} % </span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-2 padding-5 padding-tb-5">
        <div class="card text-center">
            <div class="card-content">
                <div class="card-body">
                    <div class="badge-circle badge-circle-lg badge-circle-light-primary mx-auto my-1" >
                        <i class="bx bx-file font-medium-5"></i>
                    </div>
                    <p class="text-muted mb-0 line-ellipsis">Horas extras</p>
                    <h2 class="mb-0 box_total_os">{{$totalHoraExtra}}</h2>
                    <div class="progress progress-bar-primary mb-1 mt-1"  style="color:">
                        <div class="progress-bar  progress-bar-animated box_total_progress"
                             role="progressbar" style="width:{{($allAlert>0)? number_format((float)($totalHoraExtra / $allAlert)*100, 2, '.', '') : "0"}}%"></div>
                    </div>
                    <span class="progress-description box_total_percent"totalHoraExtra>{{($allAlert>0)? number_format((float)($totalHoraExtra / $allAlert)*100, 2, '.', '') : "0"}} % </span>
                </div>
            </div>
        </div>
    </div>
</div>
