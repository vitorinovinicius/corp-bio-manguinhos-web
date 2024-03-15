@extends('layouts.frest_template')

@section('content-header')
    <div class="content-header-left col-10 mb-2 mt-1">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h5 class="content-header-title float-left pr-1 mb-0">Jornada do dia</h5>
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb p-0 mb-0">
                        <li class="breadcrumb-item"><i class="bx bx-home-alt"></i> Home</li>
                        <li class="breadcrumb-item active">Jornada do dia</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
@include('messages')
@include('helpers/filter_finish_work')

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="box-title">Resumo</h3>
            </div>
            <div class="card-content">
                <div class="card-body">
                    @if($finishWorkDays->count())
                        <div class="table-responsive">
                            <table class="table table-condensed table-striped table-sm table-hover">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Empreiteira</th>
                                    <th>Técnico</th>
                                    <th>Status</th>
                                    <th>Data da gracação</th>
                                    <th class="text-right">OPÇÕES</th>
                                </tr>
                                </thead>

                                <tbody>
                                @foreach($finishWorkDays as $finishWorkDay)
                                    <tr>
                                        <td>{{$finishWorkDay->id}}</td>
                                        <td>{{optional($finishWorkDay->contractor)->name}}</td>
                                        <td>{{$finishWorkDay->operator->name}}</td>
                                        <td>{{status_work_day($finishWorkDay->status)}}</td>
                                        <td>{{date('d/m/Y H:i:s', strtotime($finishWorkDay->date_record))}}</td>

                                        <td class="text-right">
                                            @shield('finishWorkDays.show')
                                            <a href="{{ route('finish_work_days.show', $finishWorkDay->uuid) }}" class="btn btn-icon btn-sm btn-primary" data-toggle="tooltip" data-placement="left" title="Exibir"><i class="bx bx-book-open"></i></a>
                                            @endshield
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        {!! $finishWorkDays->render() !!}
                    @else
                        <h3 class="text-center alert alert-info">Vazio!</h3>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
