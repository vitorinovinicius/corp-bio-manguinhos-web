<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 16/11/2017
 * Time: 15:40
 */

namespace App\Services;


use App\Repositories\FinancialCommunicationRepository;
use Exception;
use Illuminate\Support\Facades\Input;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Services\UploadService;

class FinancialCommunicationService
{
    /**
     * @var FinancialCommunicationRepository
     */
    private $financialCommunicationRepository;
    private $uploadService;

    /**
     * FinancialCommunicationService constructor.
     * @param FinancialCommunicationRepository $financialCommunicationRepository
     * @param \App\Services\UploadService $uploadService
     */
    public function __construct(
        FinancialCommunicationRepository $financialCommunicationRepository,
        UploadService $uploadService
    )
    {
        $this->financialCommunicationRepository = $financialCommunicationRepository;
        $this->uploadService = $uploadService;
    }

    public function index($request)
    {
        $this->financialCommunicationRepository->pushCriteria(new RequestCriteria($request));
        $financial_communications = $this->financialCommunicationRepository->paginate();

        return view('financial_communications.index', compact('financial_communications'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create($financial)
    {
        return view('financial_communications.create', compact('financial'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store($financial, $request)
    {
        $data = $request->all();
        $data["financial_id"] = $financial->id;
        $data["user_id"] = \Auth::user()->id;

        //anexo
        $anexo =  $request->input('anexo');
        try {
            $financialCommunication = $this->financialCommunicationRepository->create($data);

            if ($anexo) {
                if ($this->uploadService->fileSize($anexo)) {
                    $path = 'communication';
                    $anexoFileName = retira_acentos_espacos($anexo->getClientOriginalName());
                    $financialCommunication->anexo = $this->uploadService->uploadS3($anexo, $path, $anexoFileName);
                    $financialCommunication->anexo_name = $anexo->getClientOriginalName();
                    $financialCommunication->save();
                } else {
                    return redirect()->back()->withInput()->with('error', 'Erro ao tentar anexar arquivo.');
                }
            }
        } catch (Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Erro ao tentar salvar o item. <br>Erro: ' . $e->getMessage());
        }

//        $data["url"]  = retira_acentos_espacos($nome, "lower");
        /*
             "0" => "Pendente",
            "1" => "Resolvido",
            "2" => "Sendo avaliado",
         */
        if ($data["status"] == 0 || $data["status"] == 2) {
            $financial->status = 3;
            $financial->save();

            $occurrence = $financial->occurrence;
            $occurrence->approved = 3;
            $occurrence->save();

        } elseif ($data["status"] == 1) {
            $financial->status = 4;
            $financial->save();

            $occurrence = $financial->occurrence;
            $occurrence->approved = 4;
            $occurrence->save();
        }

        return redirect()->route('financials.show', $financial->uuid)->with('message', 'Item criado com sucesso.');
    }


    public function show($financial_communication)
    {
        return view('financial_communications.show', compact('financial_communication'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $financial_communication
     * @return Response
     */
    public function edit($financial_communication)
    {
        return view('financial_communications.edit', compact('financial_communication'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param $financial_communication
     * @param Request $request
     * @return Response
     */
    public function update($financial_communication, $request)
    {
        $data = $request->all();

        try {
            $this->financialCommunicationRepository->update($data, $financial_communication->id);
        } catch (Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Erro ao tentar editar o item. <br>Erro: ' . $e->getMessage());
        }

        /*
             "0" => "Pendente",
            "1" => "Resolvido",
            "2" => "Sendo avaliado",
         */
        if ($data["status"] == 1) {
            $financial_communication->financial->status = 4;
            $financial_communication->financial->save();

            $occurrence = $financial_communication->financial->occurrence;
            $occurrence->approved = 4;
            $occurrence->save();
        }

        return redirect()->route('financials.show', $financial_communication->financial->uuid)->with('message', 'Item atualizado com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $financialCommunication
     * @return Response
     */
    public function destroy($financialCommunication)
    {
        try {
            $financialCommunication->delete();
        } catch (Exception $e) {
            return redirect()->route('financial_communications.index')->with('error', 'Erro ao tentar excluir o item. <br>Erro: ' . $e->getMessage());
        }
        return redirect()->route('financial_communications.index')->with('message', 'Item deletado com sucesso.');
    }
}
