<?php

namespace App\Http\Controllers;

use App\Models\LogImportError;
use App\Services\LogImportErrorService;
use Illuminate\Http\Request;

class LogImportErrorController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */

    private $logImportErrorService;

    public function __construct(LogImportErrorService $logImportErrorService)
    {
        $this->logImportErrorService = $logImportErrorService;
    }

    public function index()
    {
        $log_import_errors = $this->logImportErrorService->findOrderPaginate(100);

        return view('log_import_errors.index', compact('log_import_errors'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('log_import_errors.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $this->logImportErrorService->store($data);

        return redirect()->route('admin.log_import_errors.index')->with('message', 'Item criado com sucesso.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show(LogImportError $log_import_error)
    {
        return view('log_import_errors.show', compact('log_import_error'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit(LogImportError $log_import_error)
    {
        return view('log_import_errors.edit', compact('log_import_error'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @param Request $request
     * @return Response
     */
    public function update(Request $request, LogImportError $log_import_error)
    {

        $data = $request->all();
        $this->logImportErrorService->update($log_import_error->id, $data);

        return redirect()->route('admin.log_import_errors.index')->with('message', 'Item atualizado com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy(LogImportError $log_import_error)
    {
        $this->logImportErrorService->destroy($log_import_error->id);

        return redirect()->route('admin.log_import_errors.index')->with('message', 'Item deletado com sucesso.');
    }

}
