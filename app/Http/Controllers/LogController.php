<?php namespace App\Http\Controllers;

use App\Criteria\LogFiltersCriteria;
use App\Models\ActivityLog;
use App\Repositories\ActivityLogRepository;
use Illuminate\Http\Request;
use App\Repositories\UserRepository;

class LogController extends Controller {

    private $userRepository;
    /**
     * @var ActivityLogRepository
     */
    private $activityLogRepository;

    /**
     * LogController constructor.
     * @param UserRepository $userRepository
     * @param ActivityLogRepository $activityLogRepository
     */
    public function __construct(UserRepository $userRepository,
                                ActivityLogRepository $activityLogRepository)
    {
        $this->userRepository = $userRepository;
        $this->activityLogRepository = $activityLogRepository;
    }

    public function index(Request $request)
	{
        $this->activityLogRepository->pushCriteria(new LogFiltersCriteria($request));
        $activityLog = $this->activityLogRepository->orderBy('created_at', 'desc')->paginate(100);
        $users = $this->userRepository->all();

		return view('log.index', compact('activityLog','users'));
	}
	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
        $activityLog = ActivityLog::findOrFail($id);
        $jsonDecode = logJson($activityLog->description);


		return view('log.show', compact('activityLog','jsonDecode'));
	}
}
