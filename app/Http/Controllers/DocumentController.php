<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Models\Document;
use App\Services\DocumentService;
use App\Http\Requests\DocumentRequest;
use Illuminate\Http\Request;

class DocumentController extends Controller {

    /**
     * @var DocumentService
     */
    private $documentService;

    /**
     * DocumentController constructor.
     */
    public function __construct(DocumentService $documentService)
    {
        $this->documentService = $documentService;
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
    {
        return $this->documentService->index();
    }

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
    {
        return $this->documentService->create();
    }

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(DocumentRequest $request)
    {
        return $this->documentService->store($request);
    }

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show(Document $model)
    {
        return $this->documentService->show($model);
    }

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit(Document $model)
    {
        return $this->documentService->edit($model);
    }

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update(DocumentRequest $request,Document $model)
    {
        return $this->documentService->update($model,$request);
    }

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy(Document $model)
    {
        return $this->documentService->destroy($model);
    }
}
