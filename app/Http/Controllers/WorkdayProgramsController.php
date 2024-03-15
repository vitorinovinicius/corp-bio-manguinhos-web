<?php

namespace App\Http\Controllers;

use App\Models\WorkdayPrograms;
use Illuminate\Http\Request;
use App\Services\WorkdayProgramsService;

class WorkdayProgramsController extends Controller
{
    private $workdayProgramsService;

    public function __construct(WorkdayProgramsService $workdayProgramsService)
    {
        $this->workdayProgramsService = $workdayProgramsService;
    }

    public function index()
    {
        return $this->workdayProgramsService->list();
    }

    public function create()
    {
        return $this->workdayProgramsService->create();
    }

    public function store(Request $request)
    {
        return $this->workdayProgramsService->store($request);
    }

    public function show(WorkdayPrograms $workdayPrograms)
    {
        return $this->workdayProgramsService->show($workdayPrograms);
    }

    public function edit(WorkdayPrograms $workdayPrograms)
    {
        return $this->workdayProgramsService->edit($workdayPrograms);
    }

    public function update(Request $request, WorkdayPrograms $workdayPrograms)
    {
        return $this->workdayProgramsService->update($request, $workdayPrograms);
    }

    public function destroy(WorkdayPrograms $workdayPrograms)
    {
        return $this->workdayProgramsService->destroy($workdayPrograms);
    }
}
