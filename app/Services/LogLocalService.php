<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 16/11/2017
 * Time: 15:40
 */

namespace App\Services;

use App\Repositories\LogLocalRepository;
use Exception;
use Prettus\Repository\Criteria\RequestCriteria;

class LogLocalService
{

    /**
     * @var LogLocalRepository
     */
    private $logLocalRepository;

    public function __construct(LogLocalRepository $logLocalRepository)
    {
        $this->logLocalRepository = $logLocalRepository;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @param Request $request
     * @return Response
     */
    public function save($request)
    {
        $data = $request->all();

        try {
            $this->logLocalRepository->create($data);
            return response()->json(["success" => "Track recebido com sucesso"]);
        } catch (Exception $e) {
            return response()->json(["error" => "Erro ao tentar salvar log"], 500);
        }
    }

    public function index($request)
    {
        $this->logLocalRepository->pushCriteria(new RequestCriteria($request));
        $log_locals = $this->logLocalRepository->orderBy("id","desc")->paginate(100);

        return view('log_locals.index', compact('log_locals'));
    }

    public function show($log_local)
    {
        return view('log_locals.show', compact('log_local'));
    }

}