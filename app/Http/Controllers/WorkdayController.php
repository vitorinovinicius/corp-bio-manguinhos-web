<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\WorkdayService;
use App\Models\Workday;

class WorkdayController extends Controller
{
    private $workdayService;

    public function __construct(WorkdayService $workdayService)
    {
        $this->workdayService = $workdayService;
    }

    public function index()
    {
        return $this->workdayService->listWorkday();
    }

    public function create()
    {
        return $this->workdayService->createWorkday();
    }

    public function store(Request $request)
    {
        return $this->workdayService->storeWorkday($request);
    }

    public function show(Workday $workday)
    {
        return $this->workdayService->showWorkday($workday);
    }

    public function edit(Workday $workday)
    {
        return $this->workdayService->editWorkday($workday);
    }

    public function update(Request $request, Workday $workday)
    {
        return $this->workdayService->updateWorkday($request, $workday);
    }

    public function destroy(Workday $workday)
    {
        return $this->workdayService->destroyWorkday($workday);
    }
}
