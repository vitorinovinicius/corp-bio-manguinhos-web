<?php

namespace App\Http\Controllers;

use App\Models\ChecklistVehicleBasic;
use App\Models\Occurrence;
use App\Services\PdfService;
use Illuminate\Http\Request;

class PdfController extends Controller
{
    /**
     * @var PdfService
     */
    private $pdfService;

    /**
     * PdfController constructor.
     * @param PdfService $pdfService
     */
    public function __construct(PdfService $pdfService)
    {
        $this->pdfService = $pdfService;
    }

    public function getPdfOccurence(Occurrence $occurrence, $image='', $formId='')
    {

        return $this->pdfService->getPdfOccurence($occurrence, $image, $formId);
    }

    public function getPdfChecklistVehicle(ChecklistVehicleBasic $vehicleChecklistBasic)
    {
        return $this->pdfService->getPdfChecklistVehicle($vehicleChecklistBasic);
    }

    public function getPdfRepayment(Request $request)
    {
        return $this->pdfService->getPdfRepayment($request);
    }
}
