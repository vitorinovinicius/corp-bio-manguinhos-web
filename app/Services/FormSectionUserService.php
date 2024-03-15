<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 16/11/2017
 * Time: 15:40
 */

namespace App\Services;


use App\Models\Form;
use App\Models\FormField;
use App\Models\FormSection;
use App\Repositories\FormFieldRepository;
use App\Repositories\FormGroupRepository;
use App\Repositories\FormRepository;
use App\Repositories\FormSectionRepository;
use Exception;
use Illuminate\Http\Request;
use Prettus\Repository\Criteria\RequestCriteria;

class FormSectionUserService
{
    /**
     * @var FormSectionRepository
     */
    private $formSectionRepository;
    /**
     * @var FormGroupRepository
     */
    private $formGroupRepository;
    /**
     * @var FormFieldRepository
     */
    private $formFieldRepository;
    /**
     * @var FormRepository
     */
    private $formRepository;

    /**
     * FormSectionService constructor.
     * @param FormSectionRepository $formSectionRepository
     * @param FormGroupRepository $formGroupRepository
     * @param FormFieldRepository $formFieldRepository
     * @param FormRepository $formRepository
     */
    public function __construct(
        FormSectionRepository $formSectionRepository,
        FormGroupRepository $formGroupRepository,
        FormFieldRepository $formFieldRepository,
        FormRepository $formRepository
    )
    {
        $this->formSectionRepository = $formSectionRepository;
        $this->formGroupRepository = $formGroupRepository;
        $this->formFieldRepository = $formFieldRepository;
        $this->formRepository = $formRepository;
    }

    public function index($request)
    {
        $this->formSectionRepository->pushCriteria(new RequestCriteria($request));
        $form_sections = $this->formSectionRepository->paginate();

        return view('form_sections.index', compact('form_sections'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(Form $form)
    {
        return view('form_sections.user.create', compact('form'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        try {

            $data = $request->all();

            $formsItens = $request->input("nameItem");
            $descriptionItems = $request->input("descriptionItem");
            $typeFieldItemId = $request->input("typeFieldItemId");
            $requiredItemId = $request->input("requiredItemId");
            $lists_answers = $request->input("lists_answers");


            $dataSection['name'] = $data['name'];
            $dataSection['form_id'] = $data['form_id'];

            $form_section = $this->formSectionRepository->create($dataSection);

            if ($formsItens!= null && is_array($formsItens)) {

                foreach ($formsItens as $key => $iten) {

                    $dataForm['form_section_id'] = $form_section->id;
                    $dataForm['name'] = $iten;
                    $dataForm['description'] = $descriptionItems[$key];
                    $dataForm['type_field'] = $typeFieldItemId[$key];
                    $dataForm['required'] = $requiredItemId[$key];

                    if ($dataForm['type_field'] == 3 || $dataForm['type_field'] == 1) {
                        if (isset($lists_answers[$key]) && $lists_answers[$key] != "") {
                            $dataForm['list'] = substr($lists_answers[$key], 0,-1);
                        }
                    } else {
                        $fieldData['list'] = null;
                    }

                    $this->formFieldRepository->create($dataForm);
                }

                $form = $this->formRepository->find($data['form_id']);

            } else {
                return redirect()->back()->withInput()->with('error', 'Você não adicionou nenhum campo.');
            }

            saveVersionForm($form);


        } catch (Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Erro ao tentar salvar o item. Entre em contato com o suporte');
        }

        return redirect()->route('forms.show_user', $form->uuid)->with('message', 'Item criado com sucesso.');
    }


    public function show($form_section)
    {
        return view('form_sections.show', compact('form_section'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  $form_section
     * @return Response
     */
    public function edit(FormSection $form_section)
    {
        $form = $form_section->form;
        return view('form_sections.user.edit', compact('form_section','form'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param $form_section
     * @param Request $request
     * @return Response
     */
    public function update(FormSection $form_section, Request $request)
    {
        try {

            $data = $request->all();

            $formsItens = $request->input("nameItem");
            $descriptionItems = $request->input("descriptionItem");
            $typeFieldItemId = $request->input("typeFieldItemId");
            $requiredItemId = $request->input("requiredItemId");
            $item_id = $request->input("item_id");
            $lists_answers = $request->input("lists_answers");

            $dataSection['name'] = $data['name'];
            $dataSection['form_id'] = $data['form_id'];

            $form_section   = $this->formSectionRepository->update($data, $form_section->id);

            if ($formsItens != null && count($formsItens)) {

                $itensOriginais = $form_section->form_fields()->pluck('id')->toArray();

                if ($item_id != null && count($item_id)) {
                    $deleteItens = array_diff($itensOriginais, $item_id);

                    foreach ($deleteItens as $iten) {
//                        $this->formFieldRepository->delete($iten);
                        $formField = FormField::find($iten);
                        if($formField){
                            $formField->forceDelete();
                        }
                    }
                }

                foreach ($formsItens as $key => $iten) {

                    $dataForm['form_section_id'] = $form_section->id;
                    $dataForm['name'] = $iten;
                    $dataForm['description'] = $descriptionItems[$key];
                    $dataForm['type_field'] = $typeFieldItemId[$key];
                    $dataForm['required'] = $requiredItemId[$key];

                    if ($dataForm['type_field'] == 3 || $dataForm['type_field'] == 1) {
                        if (isset($lists_answers[$key]) && $lists_answers[$key] != "") {
                            $dataForm['list'] = substr($lists_answers[$key], 0,-1);
                        } else {
                            $dataForm['list'] = null;
                        }
                    } else {
                        $dataForm['list'] = null;
                    }

                    if(isset($item_id[$key]) && $item_id[$key] != "") {
                        $this->formFieldRepository->update($dataForm, $item_id[$key]);
                    } else {
                        $this->formFieldRepository->create($dataForm);
                    }

                }

            } else {
                foreach ($form_section->form_fields as $iten) {
//                    $this->formFieldRepository->delete($iten->id);
                    $formField = FormField::find($iten->id);
                    if($formField){
                        $formField->forceDelete();
                    }
                }
            }

            $form = $this->formRepository->find($data['form_id']);

            saveVersionForm($form);

        } catch (Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Erro ao tentar editar o item. <br>Erro: '.$e->getMessage());
        }

        return redirect()->route('forms.show_user', $form->uuid)->with('message', 'Item atualizado com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $formSection
     * @return Response
     */
    public function destroy(FormSection $formSection)
    {
        try {
            $form = $formSection->form;

            foreach ($formSection->form_fields as $iten) {
                $this->formFieldRepository->delete($iten->id);
            }

            $formSection->delete();
        } catch (Exception $e) {
            return redirect()->route('forms.show_user',$form->uuid)->with('error', 'Erro ao tentar excluir o item. <br>Erro: '.$e->getMessage());
        }
        return redirect()->route('forms.show_user',$form->uuid)->with('message', 'Item excluído com sucesso.');
    }
}
