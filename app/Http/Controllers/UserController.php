<?php namespace App\Http\Controllers;

use App\Criteria\UserClientSelectCriteria;
use App\Repositories\SetorRepository;
use App\Services\ContractorService;
use App\Services\RegionService;
use Artesaos\Defender\Facades\Defender;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use App\Services\UserService;
use App\Repositories\UserRepository;

class UserController extends Controller {

	/**
	 * @var UserService
	 */
	private $userService;
	private $regionService;
    /**
     * @var SetorRepository
     */
    private $setorRepository;

    private $userRepository;

    /**
     * UserController constructor.
     * @param UserService $userService
     * @param RegionService $regionService
     * @param SetorRepository $setorRepository
     */
    public function __construct(
		UserService $userService,
        UserRepository $userRepository,
        SetorRepository $setorRepository
    )
	{
		$this->userService = $userService;
        $this->userRepository = $userRepository;
        $this->setorRepository = $setorRepository;
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{

		$users = $this->userService->listUsers();

		return view('users.index', compact('users'));
	}

    public function clients()
    {
        $this->userRepository->pushCriteria(new UserClientSelectCriteria());
        $users = $this->userRepository->paginate();

        return view('users.index_clients', compact('users'));
    }

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$roles = Defender::rolesList();
		$setores    = $this->setorRepository->all();

		return view('users.create', compact('roles','setores'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(UserRequest $request)
	{

		$this->userService->addNewUser($request);

		return redirect()->route('users.index')->with('message', 'Item criado com sucesso!.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show(User $user)
	{
	    return $this->userService->showUser($user);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit(User $user)
	{
        $roles          = Defender::rolesList();
		$selectedRoles = $user->roles->pluck('id')->toArray();

        return view('users.edit', compact('user','roles', 'selectedRoles'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update(UserRequest $request, User $user)
	{

        return $this->userService->editUser($request, $user);

	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy(User $user)
	{
	    return $this->userService->deleteUser($user);
	}

    public function changePassword(User $user)
    {
        $roles = Defender::rolesList();
        return view('users.change_password', compact('user','roles'));
    }

    public function updatePassword(Request $request, User $user)
    {
        $return = $this->userService->updatePassword($request, $user);
        return $return;
    }

    public function updateThemeColor(Request $request)
    {

        return $this->userService->updateThemeColor($request);

    }

    // public function associate_client(User $user)
    // {
    //     return $this->userService->associate_client($user);
    // }

    // public function associate_client_store(User $user, Request $request)
    // {
    //     return $this->userService->associate_client_store($user, $request);
    // }

    public function disassociate_client_store(User $user, Request $request)
    {
        return $this->userService->disassociate_client_store($user, $request);
    }

}
