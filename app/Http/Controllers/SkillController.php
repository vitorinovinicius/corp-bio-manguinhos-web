<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Models\Skill;
use App\Services\SkillService;
use App\Http\Requests\SkillRequest;
use Illuminate\Http\Request;

class SkillController extends Controller {

    /**
     * @var SkillService
     */
    private $skillService;

    /**
     * SkillController constructor.
     */
    public function __construct(SkillService $skillService)
    {
        $this->skillService = $skillService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return $this->skillService->index();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \App\Services\Response
     */
    public function create()
    {
        return $this->skillService->create();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return \App\Services\Response
     */
    public function store(SkillRequest $request)
    {
        return $this->skillService->store($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show(Skill $model)
    {
        return $this->skillService->show($model);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \App\Services\Response
     */
    public function edit(Skill $model)
    {
        return $this->skillService->edit($model);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @param Request $request
     * @return \App\Services\Response
     */
    public function update(SkillRequest $request,Skill $model)
    {
        return $this->skillService->update($model,$request);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \App\Services\Response
     */
    public function destroy(Skill $model)
    {
        return $this->skillService->destroy($model);
    }
}
