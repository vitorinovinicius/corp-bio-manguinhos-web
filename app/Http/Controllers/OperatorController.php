<?php namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

use App\Services\RegionService;
use App\Services\OperatorService;
use App\Http\Controllers\Controller;
use App\Http\Requests\OperatorRequest;
use Illuminate\Support\Facades\Response;

class OperatorController extends Controller {

	/**
	 * @var OperatorService
	 */
	private $operatorService;
    private $regionService;

	public function __construct(OperatorService $operatorService,
                                RegionService $regionService)
	{
		$this->operatorService = $operatorService;
        $this->regionService = $regionService;
	}


	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        return $operators = $this->operatorService->listOperators();

	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
	    return $this->operatorService->create();
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(OperatorRequest $request)
	{
		$this->operatorService->addNewOperator($request);

		return redirect()->route('operators.index')->with('message', 'Item criado com sucesso.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show(User $operator, Request $request)
	{
		return $this->operatorService->showOperator($operator, $request);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit(User $operator)
	{
        return $this->operatorService->edit($operator);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update(Request $request, User $user)
	{
        $this->operatorService->updateOparator($request,$user);

		return redirect()->route('operators.index')->with('message', 'Item atualizado com sucesso.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy(User $operator)
	{
		$operator->teams()->detach();
		$operator->regions()->detach();
		$operator->delete();

		return redirect()->route('operators.index')->with('message', 'Item excluído com sucesso.');
	}

	public function workday()
    {
        return $this->operatorService->listWorkday();
	}
	
	public function ajax($id)
	{	
		return $this->operatorService->ajax($id);
	}
	
	public function tracking(User $operator, Request $request)
	{
		return $this->operatorService->lisTracking($operator, $request);
	}

}
