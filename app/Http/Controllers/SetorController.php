<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setor;
use App\Services\SetorService;
use App\Repositories\UserRepository;

class SetorController extends Controller
{

    /**
	 * @var SetorService
	 */
	private $setorService;
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * TeamController constructor.
     * @param SetorService $SetorService
     * @param UserRepository $userRepository
     */
    public function __construct(SetorService $setorService, UserRepository $userRepository)
	{
		$this->setorService = $setorService;
        $this->userRepository = $userRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->setorService->index();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return $this->setorService->create();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return $this->setorService->store($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($setor)
    {
        return $this->setorService->store($setor);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($setor)
    {
        return $this->setorService->edit($setor);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $setor)
    {
        return $this->setorService->update($request,$setor);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($setor)
    {
        return $this->setorService->destroy($setor);
    }
}
