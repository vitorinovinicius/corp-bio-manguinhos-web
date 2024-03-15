<?php

namespace App\Http\Controllers;

use App\Models\LogImport;
use App\Services\LogImportErrorService;
use App\Services\logImportService;
use App\Services\UserService;
use Illuminate\Http\Request;

class LogImportController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */

    private $logImportService;
    private $userService;
    private $logImportErrorService;

    public function __construct(
        LogImportService $logImportService,
        UserService $userService,
        LogImportErrorService $logImportErrorService)
    {
        $this->logImportService = $logImportService;
        $this->userService = $userService;
        $this->logImportErrorService = $logImportErrorService;
    }

    public function index()
    {
        return $this->logImportService->index();
    }


    public function show(LogImport $log_import)
    {
        return view('log_imports.show', compact('log_import'));
    }

    public function edit(LogImport $log_import)
    {
        $users = $this->userService->all();

        return view('log_imports.edit', compact('log_import','users'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @param Request $request
     * @return Response
     */
    public function update(Request $request, LogImport $log_import)
    {

        $data = $request->all();
        $this->logImportService->update($log_import->id, $data);

        return redirect()->route('log_imports.index')->with('message', 'Item atualizado com sucesso.');
    }

    public function destroy(LogImport $log_import)
    {
        $this->logImportService->destroy($log_import);

        return redirect()->route('log_imports.index')->with('message', 'Item deletado com sucesso.');
    }

    public function log(LogImport $log_import){
        $log_import_errors = $this->logImportErrorService->findByIdLogImport($log_import->id);

        return view('log_imports.log', compact('log_import','log_import_errors'));
    }

}
