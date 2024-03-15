<?php

namespace App\Http\Controllers;

use App\Services\RoutingService;
use App\Repositories\UserRepository;

class RoutingController extends Controller
{
    private $routingService;


    public function __construct(RoutingService $routingService, UserRepository $userRepository)
    {
        $this->routingService = $routingService;

    }

    public function index()
    {
        return $this->routingService->index();
    }

}
