<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Http\Requests\OccurrenceRequest;
use App\Models\Occurrence;
use App\Models\User;
use Illuminate\Http\Request;
use App\Services\OccurrenceService;

class OccurrenceController extends Controller {

    private $occurrenceService;

    public function __construct(OccurrenceService $occurrenceService)
    {
        $this->occurrenceService = $occurrenceService;
    }


    public function index()
	{
        return $this->occurrenceService->listOccurences();
	}

    /**
     * Show the form for creating a new resource.
     *
     * @param User|null $operator
     * @return Response|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\View\View
     */
	public function create(User $operator = null)
	{
		return $this->occurrenceService->createOccurrence(null, $operator);
	}

    /**
     * Show the form for creating a new resource.
     *
     * @param Occurrence $occurrence
     * @return Response|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\View\View
     */
	public function createSubOs(Occurrence $occurrence)
	{

		return $this->occurrenceService->createOccurrence($occurrence);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(OccurrenceRequest $occurrenceRequest)
	{
	    return $this->occurrenceService->addNewOccurrence($occurrenceRequest);

	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show(Occurrence $occurrence)
	{

        return $this->occurrenceService->showOccurence($occurrence);
	}
	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function showClient(Occurrence $occurrence)
	{

        return $this->occurrenceService->showOccurenceClient($occurrence);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit(Occurrence $occurrence)
	{
	    return $this->occurrenceService->editOccurrence($occurrence);
	}

	public function editClient(Occurrence $occurrence,Request $request)
	{
		return $this->occurrenceService->editClient($occurrence, $request);
	}

	public function execute(Occurrence $occurrence)
	{
	    return $this->occurrenceService->executeOccurrence($occurrence);
	}

	public function createExecute(Request $request, Occurrence $occurrence)
	{
		return $this->occurrenceService->createExecute($request, $occurrence);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 */
	public function update(OccurrenceRequest $occurrenceRequest, Occurrence $occurrence)
	{
		return $this->occurrenceService->updateOccurrence($occurrenceRequest, $occurrence);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy(Occurrence $occurrence)
	{
		return $this->occurrenceService->deleteOs($occurrence);
	}

	public function pending(){
	    return $this->occurrenceService->listPending();
    }

	public function notExecuted(){
	    return $this->occurrenceService->listNotExecuted();
    }
    public function statusScheduleList(){
        return $this->occurrenceService->statusScheduleList();
    }
	public function unassigned(){
	    return $this->occurrenceService->listUnassigned();
    }

	public function closed(){
	    return $this->occurrenceService->listClosed();
    }

	public function closedUnsolved(){
	    return $this->occurrenceService->listClosedUnsolved();
    }

	public function toApproved(){
	    return $this->occurrenceService->listToApproved();
    }

	public function toAdjust(){
	    return $this->occurrenceService->listToAdjust();
    }

	public function approved(){
	    return $this->occurrenceService->listApproved();
    }

	public function adjusted(){
	    return $this->occurrenceService->listAdjusted();
    }

	public function disapproved(){
	    return $this->occurrenceService->listDisapproved();
    }

    public function associateStore(Request $request){
        return $this->occurrenceService->associateOsOperator($request);
    }

    public function statusSchedule(Request $request){
         return $this->occurrenceService->statusSchedule($request);
    }
    public function associateOperator(Request $request){
        return $this->occurrenceService->associateOssOperator($request);
    }

    public function export($id){
        $this->occurrenceService->exportOs($id);
    }

    public function pdfGenerate($occurrence, $image='', $formId='')
    {
        return $this->occurrenceService->pdfGenerate($occurrence, $image, $formId);
    }

    public function sendMail($occurrence){
        return $this->occurrenceService->sendMail($occurrence);
    }

    public function removeFile(Request $request){
        return $this->occurrenceService->removeFile($request);
	}

    public function operatorAjax(User $operator){
        return $this->occurrenceService->operatorAjax($operator);
	}

	public function photosUpload(Request $request){
		return $this->occurrenceService->uploadImagem($request, null);
	}

	public function storeAjax(OccurrenceRequest $occurrenceRequest){
		return $this->occurrenceService->storeAjax($occurrenceRequest);
	}

	public function updateAjax(Request $request){
		// return $request->schedule_time;
		return $this->occurrenceService->updateAjax($request);
	}

    public function uploadJson(Occurrence $occurrence){
        return $this->occurrenceService->uploadJson($occurrence);
    }

}
