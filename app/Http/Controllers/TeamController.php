<?php namespace App\Http\Controllers;

use App\Criteria\TeamCreateCriteria;
use App\Repositories\UserRepository;
use Artesaos\Defender\Role;
use App\Http\Controllers\Controller;
use App\Http\Requests\TeamRequest;
use App\Models\Setor;
use App\Services\SetorService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class  TeamController extends Controller {

	/**
	 * @var SetorService
	 */
	private $SetorService;
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * TeamController constructor.
     * @param SetorService $SetorService
     * @param UserRepository $userRepository
     */
    public function __construct(SetorService $SetorService, UserRepository $userRepository)
	{
		$this->SetorService = $SetorService;
        $this->userRepository = $userRepository;
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        $teams = $this->SetorService->listTeams();

		return view('teams.index', compact('teams'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
        // if (!\Auth::user()->contractor_id) {
        //     return redirect()->route('teams.index')->with('error', "Apenas empresas têm acesso a criar o item.");
        // }

        // $this->userRepository->pushCriteria(new TeamCreateCriteria());
        $supervisors = $this->userRepository->all();

		return view('teams.create',compact("supervisors"));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(Request $request)
	{
		return $this->SetorService->addNewTeam($request);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show(Setor $team)
	{
	    return $this->SetorService->showTeam($team);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit(Setor $team)
	{
		$role = new Role();

		$getRoleUsers = $role->where("name", "supervisor")->with("users")->get();

        $listaSupervisors = $getRoleUsers[0]->users;

        $supervisors = [];

        foreach($listaSupervisors as $user){
            if($user->contractor_id == Auth::user()->contractor_id){
                $supervisors[] = $user;
            }
        }


        return view('teams.edit', compact('team','supervisors'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update(TeamRequest $request,Setor $team)
	{
        $this->SetorService->editTeam($request, $team);

		return redirect()->route('teams.index')->with('message', 'Item atualizado com sucesso.');
	}

	// public function gantt(Request $request){
	// 	return $this->SetorService->ganttAjax($request);
	// }

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy(Setor $team)
	{
	    return $this->SetorService->deleteTeam($team);
	}

}
