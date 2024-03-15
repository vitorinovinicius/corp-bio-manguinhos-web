<?php namespace App\Http\Controllers;

use App\Models\Contractor;
use App\Http\Controllers\Controller;

use App\Services\ContractorService;
use App\Services\RegionService;
use Illuminate\Http\Request;

class ContractorController extends Controller {

	private $contractorService;
	private $regionService;

	public function __construct(ContractorService $contractorService, RegionService $regionService)
	{
		$this->regionService = $regionService;
		$this->contractorService = $contractorService;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        $contractors = $this->contractorService->listContractorsIndex();

		return view('contractors.index', compact('contractors'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{

        $regions = $this->regionService->listRegions();


        return view('contractors.create',compact("regions"));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(Request $request)
	{
		return $this->contractorService->addNewContractor($request);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show(Contractor $contractor)
	{
	    return $this->contractorService->showContractor($contractor);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit(Contractor $contractor)
	{
        $regions        = $this->regionService->listRegions();
        $selectedRegions = [];

        foreach($contractor->regions as $region) {
            $selectedRegions[] = $region->id;
        }

        return view('contractors.edit', compact('contractor','regions','selectedRegions'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update(Request $request,Contractor $contractor)
	{
        return $this->contractorService->editContractor($request, $contractor);

	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy(Contractor $contractor)
	{
	    return $this->contractorService->deleteContractor($contractor);
	}

    /**
     * Display the specified resource.
     */
    public function admimShow()
    {
        return $this->contractorService->adminShowContractor();
    }

    /**
     * Show the form for editing the specified resource.
     */

    public function adminEdit()
    {
        return $this->contractorService->editAdmin();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function adminUpdate(Request $request)
    {
        return $this->contractorService->adminUpdate($request);
    }

}
