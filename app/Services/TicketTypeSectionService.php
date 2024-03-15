<?php

namespace App\Services;

use App\Models\TicketTypeSectionField;
use App\Repositories\TicketTypeSectionRepository;
use App\Repositories\TicketTypeSectionFieldRepository;

class TicketTypeSectionService
{
    private $ticketTypeSectionRepository;
    private $ticketTypeSectionFieldRepository;

    public function __construct(TicketTypeSectionRepository $ticketTypeSectionRepository, TicketTypeSectionFieldRepository $ticketTypeSectionFieldRepository)
    {
        $this->ticketTypeSectionRepository = $ticketTypeSectionRepository;
        $this->ticketTypeSectionFieldRepository = $ticketTypeSectionFieldRepository;
    }

    public function createTicketTypeSection($ticketType)
    {
        return view('ticket_type_section.create', compact('ticketType'));
    }

    public function storeTicketTypeSection($request)
    {
        try {

            $data = $request->all();
            $ticketType = json_decode($data['ticket_type']);

            $formsItens = $request->input("nameItem");
            $descriptionItems = $request->input("descriptionItem");
            $typeFieldItemId = $request->input("typeFieldItemId");
            $requiredItemId = $request->input("requiredItemId");
            $lists_answers = $request->input("lists_answers");
            $picAmount = $request->input("picAmountId");


            $dataSection['name'] = $data['name'];
            $dataSection['ticket_type_id'] = $ticketType->id;

            if(isset($data['description']) && !empty($data['description'])){
                $dataSection['description'] = $data['description'];
            }

            $ticketTypeSection = $this->ticketTypeSectionRepository->create($dataSection);

            if ($formsItens != null && is_array($formsItens)) {

                foreach ($formsItens as $key => $iten) {

                    $dataForm['ticket_type_section_id'] = $ticketTypeSection->id;
                    $dataForm['name'] = $iten;
                    $dataForm['description'] = $descriptionItems[$key];
                    $dataForm['type_field'] = $typeFieldItemId[$key];
                    $dataForm['required'] = $requiredItemId[$key];
                    $dataForm['min_photo'] = $picAmount[$key];
                    if ($picAmount[$key] > 0) {
                        $dataForm['required_photo'] = 1;
                    }


                    if (\Auth::user()->contractor_id) {
                        $dataForm['contractor_id'] = \Auth::user()->contractor_id;
                    }

                    if ($dataForm['type_field'] == 3 || $dataForm['type_field'] == 1 || $dataForm['type_field'] == 6) {
                        if (isset($lists_answers[$key]) && $lists_answers[$key] != "") {
                            $dataForm['list'] = $lists_answers[$key];
                        }
                    } else {
                        $fieldData['list'] = null;
                    }

                    $this->ticketTypeSectionFieldRepository->create($dataForm);
                }


            }

            //todo: Verificar a necessidade
            // $form = $this->formRepository->find($data['form_id']);
            // saveVersionForm($form);

        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Erro ao tentar salvar o item. Entre em contato com o suporte');
        }

        return redirect()->route('ticket_types.show', $ticketType->uuid)->with('message', 'Seção criada com sucesso.');
    }

    public function editTicketTypeSection($ticketTypeSection)
    {
        $ticketType = $ticketTypeSection->ticketType;
        return view('ticket_type_section.edit', compact('ticketTypeSection', 'ticketType'));
    }

    public function updateTicketTypeSection($ticketTypeSection, $request)
    {
        try {

            $data = $request->all();
            $ticketType = json_decode($data['ticket_type']);
//                dd($data);
            $formsItens = $request->input("nameItem");
            $descriptionItems = $request->input("descriptionItem");
            $typeFieldItemId = $request->input("typeFieldItemId");
            $requiredItemId = $request->input("requiredItemId");
            $item_id = $request->input("item_id");
            $lists_answers = $request->input("lists_answers");
            $picAmount = $request->input("picAmount");

            $dataSection['name'] = $data['name'];
            $dataSection['ticket_type_id'] = $ticketType->id;


            $ticketTypeSection = $this->ticketTypeSectionRepository->update($data, $ticketTypeSection->id);

            if ($formsItens != null && count($formsItens)) {

                $itensOriginais = $ticketTypeSection->ticketTypeSectionFields()->pluck('id')->toArray();

                if ($itensOriginais) {
                    foreach ($itensOriginais as $iten) {
//                            $this->formFieldRepository->delete($iten);
                        $ticketTypeSectionField = TicketTypeSectionField::find($iten);
                        if($ticketTypeSectionField){
                            $ticketTypeSectionField->forceDelete();
                        }
                    }
                }

                foreach ($formsItens as $key => $iten) {

                    $dataForm['ticket_type_section_id'] = $ticketTypeSection->id;
                    $dataForm['name'] = $iten;
                    $dataForm['description'] = $descriptionItems[$key];
                    $dataForm['type_field'] = $typeFieldItemId[$key];
                    $dataForm['required'] = $requiredItemId[$key];
                    $dataForm['min_photo'] = $picAmount[$key];
                    if ($picAmount[$key] > 0) {
                        $dataForm['required_photo'] = 1;
                    } else {
                        $dataForm['required_photo'] = 0;
                    }

                    if (\Auth::user()->contractor_id) {
                        $dataForm['contractor_id'] = \Auth::user()->contractor_id;
                    }

                    if ($dataForm['type_field'] == 3 || $dataForm['type_field'] == 1 || $dataForm['type_field'] == 6) {
                        if (isset($lists_answers[$key]) && $lists_answers[$key] != "") {
                            $dataForm['list'] = $lists_answers[$key];
                        } else {
                            $dataForm['list'] = null;
                        }
                    } else {
                        $dataForm['list'] = null;
                    }

                    $this->ticketTypeSectionFieldRepository->create($dataForm);

                }
            } else {
                foreach ($ticketTypeSection->ticketTypeSectionFields as $iten) {
//                        $this->formFieldRepository->delete($iten->id);
                    $ticketTypeSectionField = TicketTypeSectionField::find($iten->id);
                    if($ticketTypeSectionField){
                        $ticketTypeSectionField->forceDelete();
                    }
                }
            }

            //todo: Verificar a necessidade
            // $form = $this->formRepository->find($data['form_id']);
            // saveVersionForm($form);

        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Erro ao tentar editar o item. <br>Erro: ' . $e->getMessage());
        }

        return redirect()->route('ticket_types.show', $ticketType->uuid)->with('message', 'Seção atualizada com sucesso.');
    }

    public function destroyTichetSection($ticketTypeSection)
    {
        try {
            $ticketType = $ticketTypeSection->ticketType;

            foreach ($ticketTypeSection->ticketTypeSectionFields as $iten) {
//                    $this->formFieldRepository->delete($iten->id);
                $ticketTypeSectionField = TicketTypeSectionField::find($iten->id);
                if($ticketTypeSectionField){
                    $ticketTypeSectionField->forceDelete();
                }
            }

            $ticketTypeSection->delete();

            // saveVersionForm($form);

        } catch (\Exception $e) {
            return redirect()->route('ticket_types.show', $ticketTypeSection->ticketType->uuid)->with('error', 'Erro ao tentar excluir o item. <br>Erro: ' . $e->getMessage());
        }
        return redirect()->route('ticket_types.show', $ticketTypeSection->ticketType->uuid)->with('message', 'Item excluído com sucesso.');
    }

    public function ticketTypeSectionByTicketType($ticketTypeId)
    {
        return $this->ticketTypeSectionRepository->findWhere(['ticket_type_id' => $ticketTypeId]);
    }
}