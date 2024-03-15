<?php

namespace App\Http\Controllers;

use App\Models\ExpenseTypes;
use App\Services\ExpenseTypesService;
use Illuminate\Http\Request;

class ExpenseTypesController extends Controller
{
    private $expenseTypesService;

    public function __construct(ExpenseTypesService $expenseTypesService)
    {
        $this->expenseTypesService = $expenseTypesService;    
    }

    public function index()
    {
        return $this->expenseTypesService->listExpenseTypes();
    }

    public function create()
    {
        return $this->expenseTypesService->createExpenseTypes();
    }

    public function store(Request $request)
    {        
        return $this->expenseTypesService->storeExpenseTypes($request);
    }

    public function show(ExpenseTypes $expenseTypes)
    {
        return $this->expenseTypesService->showExpenseTypes($expenseTypes);
    }

    public function edit(ExpenseTypes $expenseTypes)
    {
        return $this->expenseTypesService->editExpenseType($expenseTypes);
    }

    public function update(Request $request, ExpenseTypes $expenseTypes)
    {
        return $this->expenseTypesService->updateExpenseType($request, $expenseTypes);
    }

    public function destroy(ExpenseTypes $expenseTypes)
    {
        return $this->expenseTypesService->destroyExpenseType($expenseTypes);
    }
}
