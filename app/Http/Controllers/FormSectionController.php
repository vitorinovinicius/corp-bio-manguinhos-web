<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Models\Form;
use App\Models\FormSection;
use App\Services\FormSectionService;
use App\Http\Requests\FormSectionRequest;
use Illuminate\Http\Request;

class FormSectionController extends Controller {

    /**
     * @var FormSectionService
     */
    private $formSectionService;

    /**
     * FormSectionController constructor.
     */
    public function __construct(FormSectionService $formSectionService)
    {
        $this->formSectionService = $formSectionService;
    }

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \App\Services\Response
     */
	public function create(Form $form)
    {
        return $this->formSectionService->create($form);
    }

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return \App\Services\Response
     */
	public function store(FormSectionRequest $request)
    {
        return $this->formSectionService->store($request);
    }

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \App\Services\Response
     */
	public function edit(FormSection $model)
    {
        return $this->formSectionService->edit($model);
    }

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return \App\Services\Response
     */
	public function update(FormSectionRequest $request,FormSection $model)
    {
        return $this->formSectionService->update($model,$request);
    }

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \App\Services\Response
     */
	public function destroy(FormSection $model)
    {
        return $this->formSectionService->destroy($model);
    }

    public function order(Request $request)
    {
        return $this->formSectionService->order($request);
    }
}
