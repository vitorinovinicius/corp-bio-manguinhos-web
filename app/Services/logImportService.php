<?php
/**
 * Created by PhpStorm.
 * User: RAFAEL
 * Date: 15/08/2016
 * Time: 12:04
 */

namespace App\Services;


use App\Criteria\ContractorCriteria;
use App\Criteria\LogImportSelectCriteria;
use App\Criteria\UsersSelectCriteria;
use App\Repositories\ContractorRepository;
use App\Repositories\LogImportRepository;
use App\Repositories\UserRepository;

class logImportService
{

    private $logImportRepository;
    /**
     * @var UserRepository
     */
    private $userRepository;
    /**
     * @var ContractorRepository
     */
    private $contractorRepository;

    /**
     * logImportService constructor.
     * @param LogImportRepository $logImportRepository
     * @param UserRepository $userRepository
     * @param ContractorRepository $contractorRepository
     */
    public function __construct(LogImportRepository $logImportRepository, UserRepository $userRepository, ContractorRepository $contractorRepository)
    {
        $this->logImportRepository = $logImportRepository;
        $this->userRepository = $userRepository;
        $this->contractorRepository = $contractorRepository;
    }

    public function findOrFail($id){
        return $this->logImportRepository->find($id);
    }

    public function store($data){
        return $this->logImportRepository->create($data);
    }

    public function update($id, $data){
        $logImport = $this->logImportRepository->find($id);
        $logImport->fill($data);
        return $logImport->save();
    }

    public function destroy($log_import){
        //se tiver arquivo físico, deleta
        if(\File::exists($log_import->archive_path.$log_import->name_archive)){
            \File::delete($log_import->archive_path.$log_import->name_archive);
        }
        return $this->logImportRepository->delete($log_import->id);
    }

    public function donwload($log_import)
    {
        return response()->download(public_path($log_import->archive_path.$log_import->name_archive),$log_import->original_name);
    }

    public function index()
    {
        $this->logImportRepository->pushCriteria(new LogImportSelectCriteria());
        $log_imports =  $this->logImportRepository->orderBy('created_at','desc')->paginate(20);

        $this->userRepository->pushCriteria(new UsersSelectCriteria());
        $users = $this->userRepository->all();

        $this->contractorRepository->pushCriteria(new ContractorCriteria());
        $contractors = $this->contractorRepository->all();

        return view('log_imports.index', compact('log_imports','users','contractors'));
    }
}