<?php

namespace App\Http\Controllers;

use App\Models\OccurrenceArchive;
use App\Services\OccurrenceArchiveService;
use Illuminate\Http\Request;

class OccurrenceArchiveController extends Controller
{
    /**
     * @var OccurrenceArchiveService
     */
    private $occurrenceArchiveService;

    /**
     * OccurrenceArchiveController constructor.
     * @param OccurrenceArchiveService $occurrenceArchiveService
     */
    public function __construct(OccurrenceArchiveService $occurrenceArchiveService)
    {
        $this->occurrenceArchiveService = $occurrenceArchiveService;
    }

    public function store(Request $request)
    {
       return $this->occurrenceArchiveService->addAnexoOs($request);

    }

    /**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy(OccurrenceArchive $occurrenceArchive)
	{
		return $this->occurrenceArchiveService->deleteArchive($occurrenceArchive);
	}

}
