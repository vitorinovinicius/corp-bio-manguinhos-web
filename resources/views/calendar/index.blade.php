@extends('layouts.frest_template')
@section('title','- Serviços / Todos')
@section('vendor-styles')
<link rel="stylesheet" type="text/css" href="/vendors/css/calendars/tui-time-picker.css">
<link rel="stylesheet" type="text/css" href="/vendors/css/calendars/tui-date-picker.css">
<link rel="stylesheet" type="text/css" href="/vendors/css/calendars/tui-calendar.min.css">
{{-- <link rel="stylesheet" type="text/css" href="/vendors/css/calendars/fullcalendar.min.css"> --}}
@section('page-styles')
<link rel="stylesheet" type="text/css" href="/css/plugins/calendars/app-calendar.css">
<style nonce="{{ csp_nonce() }}">
    input[type='checkbox'] + span:before {
        background: transparent !important;
    }
</style>

@endsection
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/fullcalendar@5/main.min.css">

@endsection
@section('content-header')
    <div class="content-header-left col-10 mb-2 mt-1">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h5 class="content-header-title float-left pr-1 mb-0">Calendário</small></h5>
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb p-0 mb-0">
                        <li class="breadcrumb-item"><i class="bx bx-home-alt"></i> Home</li>
                        <li class="breadcrumb-item active">Calendário</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="col-2 d-flex justify-content-end align-items-center">
        @shield('occurrence.create')
        <a class="btn btn-success pull-right" href="{{ route('occurrences.create') }}"><i class="bx bx-plus"></i> Novo</a>
        @endshield
    </div>
@endsection
@section('content')
    @include('messages')
    @include('error')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="box-title">Serviços - Todos</h3>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <div class="calendar-wrapper position-relative">
                            <div class="app-content-overlay"></div>
                            <div id="sidebar" class="sidebar ps" style="position:absolute">
                                <div class="sidebar-new-schedule">
                                  <!-- create new schedule button -->
                                  {{-- <button id="btn-new-schedule" type="button" class="btn btn-primary btn-block sidebar-new-schedule-btn">
                                    New schedule
                                  </button> --}}
                                </div>
                                <!-- sidebar calendar labels -->
                                <div id="sidebar-calendars" class="sidebar-calendars">
                                    <div class="sidebar-calendars-item">
                                        <!-- view All checkbox -->
                                        <div class="checkbox">
                                            <input type="checkbox" class="checkbox-input tui-full-calendar-checkbox-square" id="checkbox1" value="all" checked="">
                                            <label for="checkbox1">Ver todos</label>
                                        </div>
                                    </div>
                                    <div id="calendarList" class="sidebar-calendars-d1"></div>
                                </div>
                                <div id="calendarList" class="sidebar-calendars-d">
                                    <div class="sidebar-calendars-item"><label><input type="checkbox" class="tui-full-calendar-checkbox-round" value="2" checked=""><span style="border-color: #39DA8A; background-color: #39DA8A;"></span><span>Realizadas</span></label></div>
                                    <div class="sidebar-calendars-item"><label><input type="checkbox" class="tui-full-calendar-checkbox-round" value="3" checked=""><span style="border-color: #FF5B5C; background-color: #FF5B5C;"></span><span>Não realizadas</span></label></div>
                                    <div class="sidebar-calendars-item"><label><input type="checkbox" class="tui-full-calendar-checkbox-round" value="4" checked=""><span style="border-color: #475F7B; background-color: #475F7B;"></span><span>Em andamento</span></label></div>
                                    <div class="sidebar-calendars-item"><label><input type="checkbox" class="tui-full-calendar-checkbox-round" value="5" checked=""><span style="border-color: #FDAC41; background-color: #FDAC41;"></span><span>Pendente</span></label></div>
                                    <div class="sidebar-calendars-item"><label><input type="checkbox" class="tui-full-calendar-checkbox-round" value="6" checked=""><span style="border-color: #000000; background-color: #000000;"></span><span>Não atribuidos</span></label></div>
                                </div>
                                <!-- / sidebar calendar labels -->
                                <div class="ps__rail-x" style="left: 0px; bottom: 0px;"><div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div></div><div class="ps__rail-y" style="top: 0px; right: 0px;"><div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 0px;"></div></div></div>
                                <div class="calendar-view p-2">
                                    <div id="calendar" class="calendar-content">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('vendor-scripts')
<script src="{{ url('https://cdn.jsdelivr.net/npm/fullcalendar@5.3.1/main.min.js') }}"></script>
<script src="{{ url('/vendors/js/calendar/tui-code-snippet.min.js') }}"></script>
<script src="{{ url('/vendors/js/calendar/tui-dom.js') }}"></script>
<script src="{{ url('/vendors/js/calendar/tui-time-picker.min.js') }}"></script>
<script src="{{ url('/vendors/js/calendar/tui-date-picker.min.js') }}"></script>
<script src="{{ url('/vendors/js/extensions/moment.min.js') }}"></script>
<script src="{{ url('/vendors/js/calendar/chance.min.js') }}"></script>
<script src="{{ url('/vendors/js/calendar/tui-calendar.min.js') }}"></script>
@section('page-scripts')
<script src="{{url('/js/scripts/extensions/calendar/app-calendar.js')}}"></script>
<script src="{{url('/js/scripts/extensions/calendar/calendars-data.js')}}"></script>
<script src="{{url('/js/scripts/extensions/calendar/schedules.js')}}"></script>
<script src="{{url('https://cdn.jsdelivr.net/npm/fullcalendar@5.3.2/locales-all.min.js')}}"></script>
    {{-- <script src="{{ url('/bower_components/AdminLTE/plugins/select2/select2.full.min.js') }}"></script> --}}
    <script nonce="{{ csp_nonce() }}">




        $(document).ready(function(){

            var check = [];

            //check all
            $('#checkbox1').click(function(event) {
                if(this.checked) {
                    $(':checkbox').each(function() {
                        this.checked = true;
                        backgroundColor = $(this).next('span').css("border-color");
                        $(this).next('span').css("background-color", backgroundColor);
                    });
                } else {
                    $(':checkbox').each(function() {
                        this.checked = false;
                        $(this).siblings('span').css("background-color","transparent");
                    });
                }
            });

            $(':checkbox').click(function(){
                check = [];
                if(this.checked == false){
                    $(this).next('span').css("background-color","transparent");
                }else{
                    backgroundColor = $(this).next('span').css("border-color");
                    $(this).next('span').css("background-color", backgroundColor);
                }
                $.each($('input:checked'), function(){
                    check.push($(this).val());
                });
                aEventos = calendar.getEvents();
                aEventos.map(function(evento){
                    if(check.indexOf(evento.extendedProps.status)>=0){
                        evento.setProp('display', 'auto');
                    }else{
                        evento.setProp('display', 'none');
                    }
                });

            });

            var calendarEl = document.getElementById('calendar');{}
            var calendar = new FullCalendar.Calendar(calendarEl, {

            initialView: 'dayGridMonth',
            locale: 'pt-br',
            timeZone: 'local',
            initialDate: moment().startOf('month').format('YYYY-MM-DD'),
            customButtons: {
                prev: {
                    text: 'prev',
                    click: function() {
                        $(':checkbox').each(function() {
                            backgroundColor = $(this).next('span').css("border-color");
                            $(this).next('span').css("background-color", backgroundColor);
                        });
                        calendar.prev();
                    }
                },
                next: {
                    text: 'next',
                    click: function() {
                        $(':checkbox').each(function() {
                            backgroundColor = $(this).next('span').css("border-color");
                            $(this).next('span').css("background-color", backgroundColor);
                        });
                        calendar.next();
                    }
                }
            },
            headerToolbar: {
                left: 'dayGridMonth,timeGridWeek,timeGridDay',
                center: 'title',
                right: 'prevYear,prev,next,nextYear'
                },
                events: function(fetchInfo, successCallback, failureCallback) {

                    eventos(fetchInfo, successCallback, failureCallback);
                },
                eventClick: function(info) {
                    var eventObj = info.event;
                    if(eventObj.url){
                        window.open(eventObj.url);
                        info.jsEvent.preventDefault();
                    }
                }
            });
            calendar.render();



        });
        function eventos(fetchInfo, successCallback, failureCallback) {
            var event = [];

            $.ajax({
                type:'GET',
                url: '{!!route("calendar.list_occurrences")!!}',
                data: {
                    "start":fetchInfo.start.toLocaleString(),
                    "end": fetchInfo.end.toLocaleString()
                    },
                async:false,
                success: function(data) {
                    data.map(function(eventEl) {
                        event.push({
                            title: eventEl.title,
                            start: eventEl.start,
                            end: eventEl.end,
                            allDay: eventEl.allDay,
                            backgroundColor: eventEl.color,
                            url:"/admin/occurrences/" + eventEl.url,
                            extendedProps: {
                                status: eventEl.status
                            }
                        });
                    });
                }
            });
            successCallback(event);
        }



    </script>
@endsection


