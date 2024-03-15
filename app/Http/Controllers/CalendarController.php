<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CalendarService;

class CalendarController extends Controller
{
    private $calendarService;

    public function __construct(CalendarService $calendarService)
    {
        $this->calendarService = $calendarService;    
    }
    public function index()
    {
        return $this->calendarService->index();
    }

    public function listOccurrences(Request $request)
    {
         return $this->calendarService->listOccurrences($request);
    }
}
