<?php namespace App\Http\Controllers;

use Artesaos\Defender\Facades\Defender;
use Artesaos\Defender\Permission;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class PermissionController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$permissions = Permission::orderBy('id', 'desc')->paginate(100);

		return view('permissions.index', compact('permissions'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('permissions.create');
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
        Defender::createPermission($data["name"], $data["readable_name"]);

		return redirect()->route('permissions.index')->with('message', 'Item criado com sucesso.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$permission = Permission::findOrFail($id);

		return view('permissions.show', compact('permission'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$permission = Permission::findOrFail($id);

		return view('permissions.edit', compact('permission'));
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
		$permission = Permission::findOrFail($id);

		$data = $request->all();

		$permission->fill($data);
		$permission->save($data);

		return redirect()->route('permissions.index')->with('message', 'Item atualizado com sucesso.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$permission = Permission::findOrFail($id);
		$permission->delete();

		return redirect()->route('permissions.index')->with('message', 'Item excluído com sucesso.');
	}

}
