<?php
/**
 * Created by PhpStorm.
 * User: RAFAEL
 * Date: 15/08/2016
 * Time: 15:18
 */

namespace App\Services;


use App\Criteria\LogImportErrorSelectCriteria;
use App\Repositories\LogImportErrorRepository;

class LogImportErrorService
{

    private $logImportErrorRepository;

    public function __construct(LogImportErrorRepository $logImportErrorRepository)
    {
        $this->logImportErrorRepository = $logImportErrorRepository;
    }

    public function findOrderPaginate($paginate){
        $this->logImportErrorRepository->pushCriteria(new LogImportErrorSelectCriteria());

        return $this->logImportErrorRepository->orderBy("created_at","desc")->paginate($paginate);
    }

    public function findOrFail($id){
        return $this->logImportErrorRepository->findOrFail($id);
    }

    public function store($data){
        return $this->logImportErrorRepository->create($data);
    }

    public function update($id, $data){
        $logImport = $this->logImportErrorRepository->findOrFail($id);
        $logImport->fill($data);
        return $logImport->save();
    }

    public function destroy($id){
        return $this->logImportErrorRepository->delete($id);
    }

    public function findByIdLogImport($idLogImport){
        $this->logImportErrorRepository->pushCriteria(new LogImportErrorSelectCriteria());

        $logImport = $this->logImportErrorRepository->findByField("log_import_id",$idLogImport);
        return $logImport;
    }
}