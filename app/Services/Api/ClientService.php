<?php

namespace App\Services\Api;

use App\Criteria\Api\FindClientCriteria;
use App\Http\Resources\Api\ClientFullResource;
use App\Repositories\OccurrenceClientRepository;
use Illuminate\Http\Request;

class ClientService
{
    /**
     * @var OccurrenceClientRepository
     */
    private $occurrenceClientRepository;

    /**
     * ClientService constructor.
     * @param OccurrenceClientRepository $occurrenceClientRepository
     */
    public function __construct(
      OccurrenceClientRepository $occurrenceClientRepository
    )
    {

        $this->occurrenceClientRepository = $occurrenceClientRepository;
    }

    public function findClient(Request $request)
    {
        $cliente_number = $request->input("cliente_number");

        if ($cliente_number) {

            $this->occurrenceClientRepository->pushCriteria(new FindClientCriteria());
            $client = $this->occurrenceClientRepository
                ->findWhere(["client_number" => $cliente_number])->first();

            if ($client) {
                return new ClientFullResource($client);
            } else {
                return response()->json(['error'=>true,'message'=>'Cliente não encontrado']);
            }

        } else {
            return response()->json(['error'=>true,'message'=>'Número de cliente não informado.']);
        }
    }
}
