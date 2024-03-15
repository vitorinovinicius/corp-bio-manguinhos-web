<?php namespace App\Http\Controllers;

use Artesaos\Defender\Facades\Defender;
use Artesaos\Defender\Role;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Services\RoleService;

class RoleController extends Controller {

    /**
     * @var RoleService
     */
    private $roleService;

    public function __construct(RoleService $roleService){
        $this->roleService = $roleService;
    }

    /**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        return $this->roleService->listRoles();
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('roles.create');
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
        Defender::createRole($data["name"]);

		return redirect()->route('roles.index')->with('message', 'Item criado com sucesso.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		return $this->roleService->showRolePermission($id);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$role = Role::findOrFail($id);

		return view('roles.edit', compact('role'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update(Request $request, $id)
	{
		$role = Role::findOrFail($id);
        $data = $request->all();

		$role->fill($data);
		$role->save($data);

		return redirect()->route('roles.index')->with('message', 'Item atualizado com sucesso.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$role = Role::findOrFail($id);
		$role->delete();

		return redirect()->route('roles.index')->with('message', 'Item excluído com sucesso.');
	}

	public function permissionUpdate(Request $request, $id){
	    return $this->roleService->permissionUpdate($request, $id);
    }

}
