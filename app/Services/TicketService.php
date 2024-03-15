<?php

namespace App\Services;

use App\Models\Ticket;
use App\Services\OccurrenceService;
use App\Repositories\UserRepository;
use App\Repositories\GroupRepository;
use App\Criteria\TicketSelectCriteria;
use App\Repositories\TicketRepository;
use App\Criteria\OccurrenceTypeCriteria;
use App\Criteria\OperatorSelectCriteria;
use App\Repositories\ContractorRepository;
use App\Repositories\TicketDataRepository;
use App\Repositories\TicketTypeRepository;
use App\Repositories\OccurrenceTypeRepository;
use App\Criteria\OccurrenceClientSelectCriteria;
use App\Repositories\OccurrenceClientRepository;
use App\Repositories\TicketImageRepository;

class TicketService
{
    /**
     * @var TicketRepository
     */
    private $ticketRepository;
    /**
     * @var \App\Services\OccurrenceService
     */
    private $occurrenceService;

    private $ticketDataRepository;

    private $occurrenceClientRepository;

    private $contractorRepository;

    private $occurrenceTypeRepository;

    private $userRepository;

    private $groupRepository;

    private $ticketTypeRepository;

    private $ticketImageRepository;

    public function __construct(
        TicketRepository $ticketRepository, 
        OccurrenceService $occurrenceService, 
        TicketDataRepository $ticketDataRepository, 
        OccurrenceClientRepository $occurrenceClientRepository, 
        ContractorRepository $contractorRepository,
        OccurrenceTypeRepository $occurrenceTypeRepository,
        UserRepository $userRepository,
        GroupRepository $groupRepository,
        TicketTypeRepository $ticketTypeRepository,
        TicketImageRepository $ticketImageRepository)
    {
        $this->ticketRepository = $ticketRepository;
        $this->occurrenceService = $occurrenceService;
        $this->ticketDataRepository = $ticketDataRepository;
        $this->occurrenceClientRepository = $occurrenceClientRepository;
        $this->contractorRepository = $contractorRepository;
        $this->occurrenceTypeRepository = $occurrenceTypeRepository;
        $this->userRepository = $userRepository;
        $this->groupRepository = $groupRepository;
        $this->ticketTypeRepository = $ticketTypeRepository;
        $this->ticketImageRepository = $ticketImageRepository;
    }

    public function dashboard()
    {
        return view('dashboards.ticket');
    }

    public function listTicket()
    {
        $occurrenceClients = $this->occurrenceClientRepository->pushCriteria(new OccurrenceClientSelectCriteria())->all();
        $tickets = $this->ticketRepository->pushCriteria(new TicketSelectCriteria())->paginate();
        return view('ticket.index', compact('occurrenceClients', 'tickets'));
    }

    public function showTicket($ticket)
    {
        $ticketData = json_decode($ticket->ticketData, true);
        $data = json_decode($ticketData['data'], true);
        $dataForms =$data['forms'][0]['sections'];  
       
        return view("ticket.show", compact('ticket', 'dataForms'));
    }

    public function createTicket()
    {
        $userClient = \Auth::user();
        $groups = $userClient->groups;
        // $occurrenceClients = $group->occurrence_clients;
        // $ticketType = $group->ticketType;
        return view("ticket.create", compact('groups'));
    }
    public function addNewFormTicket($request)
    {
        $data = $request->all();
        $group = $this->groupRepository->find($data['group_id']);
        $occurrenceClient = $this->occurrenceClientRepository->find($data['occurrence_client_id']);
        $ticketType = $this->ticketTypeRepository->find($data['ticket_type_id']);
        return view("ticket.create_form", compact('group', 'occurrenceClient', 'ticketType'));

    }
    public function addNewTicket($request)
    {
        try{

            $data = $request->all();
            $data["user_id"] = \Auth::user()->id;
            $data["contractor_id"] = \Auth::user()->contractor_id;
            $data["description_type_ticket"] = $data["ticket-type"];
            
            $ticket = $this->ticketRepository->create($data);

            $json = [];
            if (isset($data['form']) && !empty($data['form'])) {
                $json['forms'] = $data['form'];
            }

            //Procura fotos
            if (isset($json['forms']) && !empty($json['forms'])) {
                foreach ($json['forms'] as $fkey => $form) {
                    if (isset($form['sections']) && !empty($form['sections'])) {
                        foreach ($form['sections'] as $skey => $section) {
                            if (isset($section['form_fields']) && !empty($section['form_fields'])) {
                                foreach ($section['form_fields'] as $ffkey => $form_field) {
                                    if (isset($form_field['type_field']) && !empty($form_field['type_field']) && isset($form_field['value']) && !empty($form_field['value'])) {
                                        if ($form_field['type_field'] == 5 || $form_field['type_field'] == 7) {
                                            // fazer upload com o campo value
                                            $url = $this->uploadS3($form_field['value'], $ticket->id);
                                            $json['forms'][$fkey]['sections'][$skey]['form_fields'][$ffkey]['value'] = $url;
                                            $imageData = [
                                                'ticket_id' => $ticket->id,
                                                'url' => $url,
                                                'reference' => pathinfo($form_field['value']->getClientOriginalName(), PATHINFO_FILENAME),
                                                'section_id' => $section['id'],
                                                'form_field_id' => $form_field['id']
                                            ];
                                            $this->ticketImageRepository->create($imageData);
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
            //Valida checkbox vazio
            if (isset($json['forms']) && !empty($json['forms'])) {
                foreach ($json['forms'] as $fkey => $form) {
                    if (isset($form['sections']) && !empty($form['sections'])) {
                        foreach ($form['sections'] as $skey => $section) {
                            if (isset($section['form_fields']) && !empty($section['form_fields'])) {
                                foreach ($section['form_fields'] as $ffkey => $form_field) {
                                    if (isset($form_field['type_field']) && !empty($form_field['type_field'])) {
                                        if ($form_field['type_field'] == 1 && !isset($form_field['value'])) {
                                            $json['forms'][$fkey]['sections'][$skey]['form_fields'][$ffkey]['value'] = null;
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }

            $data['json'] = $json;
        
           
            $this->ticketDataRepository->create(['ticket_id'=>$ticket->id, 'data'=>json_encode($data['json'])]);
            return redirect()->route('client.index')->with('message', 'Ticket criado com sucesso.');
        }catch (\Exception $e){
            return redirect()->back()->with('error', 'Não foi possível executar a solicitação.<br>Erro: '.$e->getMessage());
        }

        //todo: Realizar a mecanica de envio de email
    }

    public function updateTicket()
    {

    }

    public function createOS($ticket)
    {
        $occurrence = null;

        $contractors = $this->contractorRepository->all();

        $occurrence_types = $this->occurrenceTypeRepository->pushCriteria(new OccurrenceTypeCriteria())->all();
        $operators = $this->userRepository->pushCriteria(new OperatorSelectCriteria())->all();

        $ticketData = json_decode($ticket->ticketData, true);
        $data = json_decode($ticketData['data'], true);
        $dataForms =$data['forms'][0]['sections'];  

        return view ('occurrences.create', compact('occurrence','operators', 'occurrence_types','ticket', 'dataForms'));
        // return $this->occurrenceService->createOccurrence('','',$dataTicket);

    }

    public function cancel($ticket)
    {
        return view('ticket.cancel', compact('ticket'));
    }

    public function cancelUpdate($ticket, $request)
    {
        try{
            $data = $request->all();
            $data['status'] = 2;
            $this->ticketRepository->update($data, $ticket->id);
            return redirect()->route('ticket.show', $ticket->uuid)->with('message', 'Ticket atualizado com sucesso.');
        }catch (\Exception $e){
            return redirect()->back()->with('error', 'Não foi possível executar a solicitação.<br>Erro: '.$e->getMessage());
        }
    }

    private function uploadS3($arquivo, $ticket_id)
    {
        $archivePath = "temp/";
        $fileName = md5(date("Y_m_d_h_i_s")) . "_" . rand() . "." . $arquivo->getClientOriginalExtension();
        $path = $archivePath . $fileName;
        $arquivo->move($archivePath, $fileName);
        $s3Client = \Storage::disk('s3');
        $image_name = env("S3_PATH") . get_contractor_to_s3() . "images/occurrences/" . $ticket_id . "/" . $fileName;


        if (\File::exists($path)) {
            $contents = \File::get($path);
            $s3Client->put($image_name, $contents);
            \File::delete($path);
            return $s3Client->url($image_name);
        }
    }

}
