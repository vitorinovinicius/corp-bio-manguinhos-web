<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\OccurrenceOrderService;
use Illuminate\Http\Request;

class OccurrenceOrderController extends Controller 
{
    private $occurrenceOrderService;

    public function __construct(OccurrenceOrderService $occurrenceOrderService)
    {
        $this->occurrenceOrderService = $occurrenceOrderService;
    }

    public function order(Request $request)
    {
        return $this->occurrenceOrderService->order($request);
	}

	public function route($id)
	{
		return $this->occurrenceOrderService->route($id);
	}
}