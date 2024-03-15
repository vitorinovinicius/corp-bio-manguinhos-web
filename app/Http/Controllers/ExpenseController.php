<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Services\ExpenseService;
use Illuminate\Http\Request;


class ExpenseController extends Controller
{
    private $expenseService;

    public function __construct(ExpenseService $expenseService)
    {
        $this->expenseService = $expenseService;

    }

    public function index()
    {
        return $this->expenseService->listExpenses();
    }

    public function create()
    {
        return $this->expenseService->create();
    }

    public function createOperatorExpense($operator, $starDate = '', $endDate = '')
    {
        return $this->expenseService->createOperatorExpense($operator, $starDate, $endDate);
    }

    public function store(Request $request)
    {
        return $this->expenseService->storeExpense($request);
    }

    public function show(Expense $expense)
    {
        return $this->expenseService->showExpense($expense);
    }

    public function edit(Expense $expense)
    {
       return $this->expenseService->editExpense($expense);
    }

    public function update(Request $request, Expense $expense)
    {
        return $this->expenseService->updateExpense($request, $expense);
    }

    public function destroy(Expense $expense)
    {
        return $this->expenseService->destroyExpense($expense);
    }

    public function removePhoto(Request $request)
    {
        return $this->expenseService->removePhoto($request);
    }

    public function status(Request $request)
    {
        return $this->expenseService->status($request);
    }

    public function bulkStatus(Request $request)
    {
        return $this->expenseService->bulkStatus($request);
    }
}
