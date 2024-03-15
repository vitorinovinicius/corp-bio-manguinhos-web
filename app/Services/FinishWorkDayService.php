<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 16/11/2017
 * Time: 15:40
 */

namespace App\Services;
use App\Criteria\FinisshWorkDayCriteria;
use App\Criteria\OperatorSelectCriteria;
use App\Repositories\ContractorRepository;
use App\Repositories\FinishWorkDayRepository;
use App\Repositories\UserRepository;

class FinishWorkDayService
{
    /**
     * @var FinishWorkDayRepository
     */
    private $finishWorkDayRepository;
    private $userRepository;
    private $contractorRepository;

    public function __construct(
        FinishWorkDayRepository $finishWorkDayRepository,
        UserRepository $userRepository,
        ContractorRepository $contractorRepository
    )
        {
            $this->finishWorkDayRepository = $finishWorkDayRepository;
            $this->userRepository = $userRepository;
            $this->contractorRepository = $contractorRepository;


        }

    public function index()
    {
        $this->finishWorkDayRepository->pushCriteria(new FinisshWorkDayCriteria());
        $finishWorkDays = $this->finishWorkDayRepository->paginate();
        $this->userRepository->pushCriteria(new OperatorSelectCriteria());
        $operators = $this->userRepository->findWhere(["status" => 1]);

        $contractors = $this->contractorRepository->all();

        return view('finish_work_day.index', compact('finishWorkDays','operators','contractors'));
    }
    public function show($finishWorkDay)
    {

        return view('finish_work_day.show', compact('finishWorkDay'));
    }
}