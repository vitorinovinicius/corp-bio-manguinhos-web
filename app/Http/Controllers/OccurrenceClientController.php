<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Http\Requests\OccurrenceClientRequest;
use App\Models\OccurrenceClient;
use Illuminate\Http\Request;
use App\Services\OccurrenceClientService;

class OccurrenceClientController extends Controller {

    private $occurrenceClientService;

    public function __construct(
        OccurrenceClientService $occurrenceClientService
        )
    {
        $this->occurrenceClientService = $occurrenceClientService;
    }

    /**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return $this->occurrenceClientService->listClients();
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('occurrence_clients.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(OccurrenceClientRequest $occurrenceClientRequest)
	{
	    return $this->occurrenceClientService->storeClient($occurrenceClientRequest);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show(OccurrenceClient $occurrenceClient)
	{
	    return $this->occurrenceClientService->showClient($occurrenceClient);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit(OccurrenceClient $occurrenceClient)
    {
        return $this->occurrenceClientService->editClient($occurrenceClient);

	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update(OccurrenceClientRequest $occurrenceClientRequest, OccurrenceClient $occurrenceClient)
	{
	    return $this->occurrenceClientService->updateClient($occurrenceClientRequest, $occurrenceClient);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy(OccurrenceClient $occurrenceClient)
	{
		return $this->occurrenceClientService->deleteClient($occurrenceClient);
	}
	
	public function getClientAjax($id)
	{
		return $this->occurrenceClientService->getClientAjax($id);		
    }
	

	public function getClientAjaxSelect2(Request $request)
	{
		return $this->occurrenceClientService->getClientAjaxSelect2($request);		
    }

	public function listOccurrenceClientByGroup($groupId)
	{
		return $this->occurrenceClientService->listOccurrenceClientByGroup($groupId);
	}

}
