<?php

namespace App\Http\Controllers;

use App\Services\ContractorService;
use Illuminate\Http\Request;


use App\Services\ImportService;

class ImportController extends Controller
{
    private $importService;
    private $contractorService;


    public function __construct(ImportService $importService,
                                ContractorService $contractorService
                                )
    {
        $this->importService = $importService;
        $this->contractorService = $contractorService;


    }

    public function index()
    {
        return $this->importService->index();
    }

    public function importPersonal()
    {
        return view('import_os.import_nts');
    }

    public function pecas()
    {
        $contractors    = $this->contractorService->listContractors();


        return view('import_pecas.index',compact('contractors'));
    }

    public function importExcel(Request $request)
    {
        return $this->importService->import($request);
    }

    public function importNts()
    {
//        return $this->importService->import_nts();
        return $this->importService->importPersonal();
    }
}
