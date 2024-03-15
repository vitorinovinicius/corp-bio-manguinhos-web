<?php
/**
 * Created by PhpStorm.
 * User: RAFAEL
 * Date: 15/08/2016
 * Time: 20:14
 */

namespace App\Services;
ini_set('max_execution_time', 0); //10 minutos
ini_set('max_input_time', 0);

use App\Imports\OccurrenceImport;
use App\Repositories\ContractorDistrictRepository;
use App\Repositories\ContractorOccurrenceTypeRepository;
use App\Repositories\ContractorRepository;
use App\Repositories\DistrictRepository;
use App\Repositories\OccurrenceClientPhoneRepository;
use App\Repositories\OccurrenceClientRepository;
use App\Repositories\OccurrenceDataBasicRepository;
use App\Repositories\OccurrenceRepository;
use App\Repositories\OccurrenceTypeRepository;
use App\Repositories\UserRepository;
use File;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Facades\Auth;
use App\Repositories\LogImportErrorRepository;
use App\Repositories\LogImportRepository;
use Maatwebsite\Excel\Facades\Excel;
use Storage;

class ImportService
{
    private $logImportRepository;
    private $logImportErrorRepository;
    private $occurrenceClientRepository;
    private $occurrenceClientsPhoneRepository;
    private $occurrenceRepository;
    private $occurrenceTypeRepository;
    private $occurrenceDataBasicRepository;
    /**
     * @var DistrictRepository
     */
    private $districtRepository;
    /**
     * @var ContractorDistrictRepository
     */
    private $contractorDistrictRepository;
    /**
     * @var ContractorOccurrenceTypeRepository
     */
    private $contractorOccurrenceTypeRepository;
    /**
     * @var UserRepository
     */
    private $userRepository;
    /**
     * @var ContractorRepository
     */
    private $contractorRepository;


    /**
     * ImportService constructor.
     * @param LogImportRepository $logImportRepository
     * @param LogImportErrorRepository $logImportErrorRepository
     * @param OccurrenceClientRepository $occurrenceClientRepository
     * @param OccurrenceClientPhoneRepository $occurrenceClientsPhoneRepository
     * @param OccurrenceRepository $occurrenceRepository
     * @param OccurrenceTypeRepository $occurrenceTypeRepository
     * @param OccurrenceDataBasicRepository $occurrenceDataBasicRepository
     * @param DistrictRepository $districtRepository
     * @param ContractorDistrictRepository $contractorDistrictRepository
     * @param ContractorOccurrenceTypeRepository $contractorOccurrenceTypeRepository
     * @param UserRepository $userRepository
     * @param ContractorRepository $contractorRepository
     */
    public function __construct(
        LogImportRepository $logImportRepository,
        LogImportErrorRepository $logImportErrorRepository,
        OccurrenceClientRepository $occurrenceClientRepository,
        OccurrenceClientPhoneRepository $occurrenceClientsPhoneRepository,
        OccurrenceRepository $occurrenceRepository,
        OccurrenceTypeRepository $occurrenceTypeRepository,
        OccurrenceDataBasicRepository $occurrenceDataBasicRepository,
        DistrictRepository $districtRepository,
        ContractorDistrictRepository $contractorDistrictRepository,
        ContractorOccurrenceTypeRepository $contractorOccurrenceTypeRepository,
        UserRepository $userRepository,
        ContractorRepository  $contractorRepository
    )
    {
        $this->logImportRepository = $logImportRepository;
        $this->logImportErrorRepository = $logImportErrorRepository;
        $this->occurrenceClientRepository = $occurrenceClientRepository;
        $this->occurrenceClientsPhoneRepository = $occurrenceClientsPhoneRepository;
        $this->occurrenceRepository = $occurrenceRepository;
        $this->occurrenceTypeRepository = $occurrenceTypeRepository;
        $this->occurrenceDataBasicRepository = $occurrenceDataBasicRepository;
        $this->districtRepository = $districtRepository;
        $this->contractorDistrictRepository = $contractorDistrictRepository;
        $this->contractorOccurrenceTypeRepository = $contractorOccurrenceTypeRepository;
        $this->userRepository = $userRepository;
        $this->contractorRepository = $contractorRepository;
    }

    public function index()
    {
        $contractors = $this->contractorRepository->all();
        return view('import_os.index',compact('contractors'));
    }


    //import excel
    public function import($request)
    {

        $data = $request->all();

        $qtdError = 0;
        //PEGANDO PATH PADRAO PARA SALVAR OS ARQUIVOS DE IMPORT
        $archivePath = "imports/";

        //VERIFICANDO SE EXISTE O ARQUIVO

        $csv = $request->file('csv');

        if (!$csv) {
             return redirect()->back()->exceptInput()->with('error', 'Nenhum arquivo foi passado');
        } else {
            try {
                if (!\Auth::user()->contractor_id) {
                    return redirect()->route('import_os.index')->with('error', "Apenas empresa podem tem acesso a importação.");
                } else {
                    $contractor_id = \Auth::user()->contractor_id;
                }

                if (empty($csv) && !$csv->isValid()) {
                    return redirect()->back()->exceptInput()->with('error', 'Arquivo invalido.');
                }

                //PEGANDO O NOME DO ARQUIVO
                //        $fileName = $csv->getClientOriginalName();
                $fileName = "import_csv_" . date("Y_m_d_h_i_s") . "." . $csv->getClientOriginalExtension();

                $path = $archivePath . $fileName;

                if (file_exists($path)) {
                    return redirect()->back()->exceptInput()->with('error', 'O arquivo enviado já existe! <br>Caso seja um novo arquivo, favor renomear e tente novamente.');
                }
                // FAZENDO O UPLOAD DO ARQUIVO PARA O PATH DEFINIDO
                $csv->move($archivePath, $fileName);
                //GERANDO O LOGIMPORT

                $dadosLogImport = array(
                    "user_id" => Auth::user()->id,
                    "name_archive" => $fileName,
                    "original_name" => $csv->getClientOriginalName(),
                    "archive_path" => $archivePath,
                    "contractor_id" => $contractor_id
                );

                $logImport = $this->logImportRepository->create($dadosLogImport);

                if (is_file($path)) {
                    //sobe para S3
                    $base = env('S3_PATH', 'centralmob/trial_staging/');
                    $archive_name = $base . "imports/" . $fileName;
                    $s3Client = Storage::disk('s3');
                    try {
                        $contents = File::get($path);
                    } catch (FileNotFoundException $e) {
                        return redirect()->back()->exceptInput()->with('error', 'Não pode encontrar o arquivo para subir ao S3. Erro: ' . $e->getMessage());
                    }
                    $s3Client->put($archive_name, $contents);
                    $logImport->url = $s3Client->url($archive_name);
                    $logImport->save();
                }

                if ($csv->getClientOriginalExtension() == "csv") {
                    Excel::import(new OccurrenceImport($logImport,$contractor_id,$this->occurrenceRepository,$this->logImportErrorRepository,$this->occurrenceTypeRepository,$this->occurrenceClientRepository,$this->occurrenceClientsPhoneRepository, $this->userRepository), $path, null, \Maatwebsite\Excel\Excel::CSV);
                } elseif($csv->getClientOriginalExtension() == "xlsx" || $csv->getClientOriginalExtension() == "xls") {
                    Excel::import(new OccurrenceImport($logImport,$contractor_id,$this->occurrenceRepository,$this->logImportErrorRepository,$this->occurrenceTypeRepository,$this->occurrenceClientRepository,$this->occurrenceClientsPhoneRepository,$this->userRepository), $path);
                }else{
                    return redirect()->back()->exceptInput()->with('error', 'Formato de arquivo não suportado.');
                }

                //deleta arquivo
                File::delete($path);


            } catch (\Exception $e) {
                return redirect()->back()->exceptInput()->with('error', 'Houve algum erro grave com o arquivo enviado, por favor envie essa mensagem para equipe técnica junto com o arquivo enviado para o e-mail suporte@centralsystem.com.br.<br> Mensagem: ' . $e->getMessage());
            }
        }

        return redirect()->route('log_imports.show', $logImport->uuid)->with('message', 'Importação realizada com sucesso.');

    }

    private function registerLogImportError($log_import_id, $lineNumber, $lineDetail, $errorMessage, $empreiteira = null)
    {
        $data = array(
            "log_import_id" => $log_import_id,
            "line_number" => $lineNumber,
            "line_detail" => $lineDetail,
            "error_message" => $errorMessage,
        );

        if($empreiteira != null) {
            $data["contractor_id"] = $empreiteira->id;
        }

        $this->logImportErrorRepository->create($data);
    }

}
