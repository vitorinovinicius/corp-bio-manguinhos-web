<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Http\Requests\AppVersionRequest;
use App\Services\AppService;
use Illuminate\Http\Request;

class AppVersionController extends Controller {

    private $appService;

    public function __construct(AppService $appService)
    {
        $this->appService = $appService;
    }
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        $app_versions = $this->appService->listaAppVersion();

		return view('app_versions.index', compact('app_versions'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('app_versions.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(AppVersionRequest $request)
	{
        return $this->appService->salvarApk($request);
	}

    public function status($app_version, $status)
    {
        return $this->appService->salvarStatus($app_version, $status);
	}
    public function download($version)
    {
        return $this->appService->download($version);
    }

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($app_version)
	{

	    return $this->appService->destroy($app_version);

	}

    public function latestVersion()
    {
        return $this->appService->latestVersion();
	}

}
