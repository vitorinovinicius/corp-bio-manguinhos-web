<?php namespace App\Http\Controllers;


use App\Http\Controllers\Controller;
use App\Http\Requests\InterferenceRequest;
use App\Models\Interference;
use App\Services\InterferenceService;
use Illuminate\Http\Request;


class InterferenceController extends Controller {

    private $interferenceService;

    public function __construct(InterferenceService $interferenceService)
	{
        $this->interferenceService = $interferenceService;
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        $interferences = $this->interferenceService->listInterferences();

		return view('interferences.index', compact('interferences'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
        if (!\Auth::user()->contractor_id) {
            return redirect()->route('interferences.index')->with('error', "Apenas empresas têm acesso a criar o item.");
        }

		return view('interferences.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(InterferenceRequest $request)
	{
		return $this->interferenceService->addNewInterference($request);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show(Interference $interference)
	{
	    return $this->interferenceService->showInterference($interference);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit(Interference $interference)
	{
		return view('interferences.edit', compact('interference'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update(InterferenceRequest $request,Interference $interference)
	{
        $this->interferenceService->editInterference($request, $interference);

		return redirect()->route('interferences.index')->with('message', 'Item atualizado com sucesso.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy(Interference $interference)
	{
	    return $this->interferenceService->deleteInterference($interference);
	}


	public function dashboard()
	{
	    return $this->interferenceService->dashboard();

	}

	public function clients()
	{
	    return $this->interferenceService->clients();

	}

	public function dashboard_ajax(Request $request)
	{
        return $this->interferenceService->dashboard_ajax($request);

	}

	public function relatorio_show(Interference $interference)
	{
        return $this->interferenceService->relatorio_show($interference);
	}
}
