<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Models\Financial;
use App\Models\Occurrence;
use App\Services\FinancialService;
use App\Http\Requests\FinancialRequest;
use Illuminate\Http\Request;

class FinancialController extends Controller {

    /**
     * @var FinancialService
     */
    private $financialService;

    /**
     * FinancialController constructor.
     * @param FinancialService $financialService
     */
    public function __construct(FinancialService $financialService)
    {
        $this->financialService = $financialService;
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
    {
        return $this->financialService->index();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Occurrence $occurrence
     * @return \App\Services\Response
     */
	public function create(Occurrence $occurrence)
    {
        return $this->financialService->create($occurrence);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Occurrence $occurrence
     * @param FinancialRequest $request
     * @return \App\Services\Response
     */
	public function store(Occurrence $occurrence, FinancialRequest $request)
    {
        return $this->financialService->store($occurrence, $request);
    }

    /**
     * Display the specified resource.
     *
     * @param Financial $model
     * @return Response
     */
	public function show(Financial $model)
    {
        return $this->financialService->show($model);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Financial $model
     * @return \App\Services\Response
     */
	public function edit(Financial $model)
    {
        return $this->financialService->edit($model);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param FinancialRequest $request
     * @param Financial $model
     * @return \App\Services\Response
     */
	public function update(FinancialRequest $request,Financial $model)
    {
        return $this->financialService->update($model,$request);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Financial $model
     * @return \App\Services\Response
     */
	public function destroy(Financial $model)
    {
        return $this->financialService->destroy($model);
    }

    public function dashboard_ajax(Request $request)
    {
        return $this->financialService->dashboard_ajax($request);
    }

    public function dashboard()
    {
        return $this->financialService->dashboard();
    }
}
