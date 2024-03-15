<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ArchiveService;

class ArchiveController extends Controller
{
    private $archiveService;

    public function __construct(ArchiveService $archiveService)
    {
        $this->archiveService = $archiveService;
    }

    public function destroy(Request $request)
    {
        return $this->archiveService->destroyArchive($request);
    }
}
