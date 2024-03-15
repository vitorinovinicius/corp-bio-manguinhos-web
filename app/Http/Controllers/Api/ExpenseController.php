<?php

namespace App\Http\Controllers\Api;

use App\Services\Api\ExpenseService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    /**
     * @var ExpenseService
     */
    private $expenseService;

    /**
     * ExpenseController constructor.
     * @param ExpenseService $expenseService
     */
    public function __construct(ExpenseService $expenseService)
    {
        $this->expenseService = $expenseService;
    }

    public function list(Request $request)
    {
        return $this->expenseService->list($request);
    }

    public function store(Request $request)
    {
        return $this->expenseService->store($request);
    }

    public function imageStore(Request $request)
    {
        return $this->expenseService->imageStore($request);
    }
}
