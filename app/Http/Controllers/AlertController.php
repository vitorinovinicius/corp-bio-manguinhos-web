<?php

namespace App\Http\Controllers;

use App\Models\Alert;
use App\Services\AlertService;
use Illuminate\Http\Request;

class AlertController extends Controller
{
    /**
     * @var AlertService
     */
    private $alertService;

    /**
     * AlertController constructor.
     */
    public function __construct(AlertService $alertService)
    {
        $this->alertService = $alertService;
    }

    public function index()
    {
        return $this->alertService->index();
    }

    public function store(Request $request)
    {
        return $this->alertService->store($request);
    }
    public function show(Alert $alert)
    {
        return $this->alertService->show($alert);
    }
    public function edit(Alert $alert){
        return $this->alertService->edit($alert);
    }

    public function update(Request $request, Alert $alert)
    {
        return $this->alertService->update($request,$alert);
    }
    public function destroy(Alert $alert)
    {
        return $this->alertService->delete($alert);
    }

    public function show_packages(Request $request)
    {
        return $this->alertService->show_packages($request);
    }

    public function show_routes(Request $request)
    {
        return $this->alertService->show_routes($request);
    }

    public function show_document(Alert $alert)
    {
        return $this->alertService->show_document($alert);
    }

    public function documents_close(Request $request, Alert $alert)
    {
        return $this->alertService->documents_close($request, $alert);
    }
}
