<?php

    namespace App\Services;

    use Carbon\Carbon;
    use DateTime;

    class CalendarService
    {
        public function index()
        {
            return view('calendar.index');
        }

        public function listOccurrences($request)
        {
            $where = '';
            if ($request->all()) {

                $start = Carbon::parse(str_replace('/', '-', $request->start))->format('Y-m-d');
                $end = Carbon::parse(str_replace('/', '-', $request->end))->format('Y-m-d');

                $where .= " AND occ.schedule_date BETWEEN '$start' AND '$end'";
            }

            if (\Auth::user()->contractor_id) {
                $where .= " AND occ.contractor_id = " . \Auth::user()->contractor_id;
            }

            $occurrences = \DB::select('SELECT DISTINCT occ.id, ot.name, occ.schedule_date, occ.schedule_time, occ.uuid, ot.average_time, occ.shift, u.name as operator_name,
            case
                when (occ.status = 2) THEN "2"
                when (occ.status = 1 and occ.operator_id is not null) then "5"
                when (occ.status = 3) then "3"
                when (occ.status =1 and moves.move_type_id = 5) then "4"
                when (occ.status = 1 and occ.operator_id is null) then "6"
            END as status
            FROM occurrences occ
            LEFT JOIN occurrence_types ot on (occ.occurrence_type_id = ot.id)
            LEFT JOIN moves on (occ.id = moves.occurrence_id)
            LEFT JOIN users u on (occ.operator_id = u.id)
            WHERE occ.id IS NOT NULL
            ' . $where);
            // return $occurrences;

            $calendarOccurrences = [];
            foreach ($occurrences as $occurrence) {

                if ($occurrence->average_time && $occurrence->schedule_time) {
                    $schedule_time = Carbon::createFromFormat("H:i:s",$occurrence->schedule_time);

                    $time = explode(":", $occurrence->average_time);
                    $hour = $time[0];
                    $minute = $time[1];

                    $date_final = $schedule_time->addHours($hour)->addMinutes($minute)->format("H:i:s");

                    $end = "{$occurrence->schedule_date}T{$date_final}";
                } else {
                    $end = null;
                }

                $shift = $occurrence->shift ? occurrence_shift($occurrence->shift) . " - " : "";
                $operator = $occurrence->operator_name ? " - " . $occurrence->operator_name : "";

                $calendarOccurrences[] = [
                    "title" => $shift . $occurrence->name . $operator,
                    "start" => ($occurrence->schedule_time != null) ? "{$occurrence->schedule_date}T{$occurrence->schedule_time}" : "$occurrence->schedule_date",
                    "end" => $end,
                    "allDay" => ($occurrence->schedule_time != null) ? false : true,
                    "color" => colorEventCalendar($occurrence->status),
                    "status" => $occurrence->status,
                    "url" => $occurrence->uuid
                ];
            }
            return $calendarOccurrences;
        }
    }
