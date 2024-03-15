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

    class FormSectionService
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
        public function __construct(FormSectionRepository $formSectionRepository, FormGroupRepository $formGroupRepository, FormFieldRepository $formFieldRepository, FormRepository $formRepository)
        {
            $this->formSectionRepository = $formSectionRepository;
            $this->formGroupRepository = $formGroupRepository;
            $this->formFieldRepository = $formFieldRepository;
            $this->formRepository = $formRepository;
        }

        /**
         * Show the form for creating a new resource.
         *
         * @return Response|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\View\View
         */
        public function create(Form $form)
        {
            return view('form_sections.create', compact('form'));
        }

        /**
         * Store a newly created resource in storage.
         *
         * @param Request $request
         * @return \Illuminate\Http\RedirectResponse
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
                $picAmount = $request->input("picAmountId");


                $dataSection['name'] = $data['name'];
                $dataSection['form_id'] = $data['form_id'];

                if(isset($data['description']) && !empty($data['description'])){
                    $dataSection['description'] = $data['description'];
                }

                $form_section = $this->formSectionRepository->create($dataSection);

                if ($formsItens != null && is_array($formsItens)) {

                    foreach ($formsItens as $key => $iten) {

                        $dataForm['form_section_id'] = $form_section->id;
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

                        $this->formFieldRepository->create($dataForm);
                    }


                }
//                else {
//                    return redirect()->back()->withInput()->with('error', 'Você não adicionou nenhum campo.');
//                }

                $form = $this->formRepository->find($data['form_id']);
                saveVersionForm($form);

            } catch (Exception $e) {
                return redirect()->back()->withInput()->with('error', 'Erro ao tentar salvar o item. Entre em contato com o suporte');
            }

            return redirect()->route('forms.show', $form->uuid)->with('message', 'Seção criada com sucesso.');
        }

        /**
         * Show the form for editing the specified resource.
         *
         * @param  $form_section
         * @return Response|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\View\View
         */
        public function edit($form_section)
        {
            $form = $form_section->form;
            return view('form_sections.edit', compact('form_section', 'form'));
        }

        /**
         * Update the specified resource in storage.
         *
         * @param $form_section
         * @param Request $request
         * @return \Illuminate\Http\RedirectResponse
         */
        public function update(FormSection $form_section, Request $request)
        {
            try {

                $data = $request->all();
//                dd($data);
                $formsItens = $request->input("nameItem");
                $descriptionItems = $request->input("descriptionItem");
                $typeFieldItemId = $request->input("typeFieldItemId");
                $requiredItemId = $request->input("requiredItemId");
                $item_id = $request->input("item_id");
                $lists_answers = $request->input("lists_answers");
                $picAmount = $request->input("picAmount");

                $dataSection['name'] = $data['name'];
                $dataSection['form_id'] = $data['form_id'];


                $form_section = $this->formSectionRepository->update($data, $form_section->id);

                if ($formsItens != null && count($formsItens)) {

                    $itensOriginais = $form_section->form_fields()->pluck('id')->toArray();

                    if ($itensOriginais) {
                        foreach ($itensOriginais as $iten) {
//                            $this->formFieldRepository->delete($iten);
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

                        $this->formFieldRepository->create($dataForm);

                    }
                } else {
                    foreach ($form_section->form_fields as $iten) {
//                        $this->formFieldRepository->delete($iten->id);
                        $formField = FormField::find($iten->id);
                        if($formField){
                            $formField->forceDelete();
                        }
                    }
                }

                $form = $this->formRepository->find($data['form_id']);

                saveVersionForm($form);

            } catch (Exception $e) {
                return redirect()->back()->withInput()->with('error', 'Erro ao tentar editar o item. <br>Erro: ' . $e->getMessage());
            }

            return redirect()->route('forms.show', $form->uuid)->with('message', 'Seção atualizada com sucesso.');
        }

        /**
         * Remove the specified resource from storage.
         *
         * @param $formSection
         * @return \Illuminate\Http\RedirectResponse
         */
        public function destroy(FormSection $formSection)
        {
            try {
                $form = $formSection->form;

                foreach ($formSection->form_fields as $iten) {
//                    $this->formFieldRepository->delete($iten->id);
                    $formField = FormField::find($iten->id);
                    if($formField){
                        $formField->forceDelete();
                    }
                }

                $formSection->delete();

                saveVersionForm($form);

            } catch (Exception $e) {
                return redirect()->route('forms.show', $form->uuid)->with('error', 'Erro ao tentar excluir o item. <br>Erro: ' . $e->getMessage());
            }
            return redirect()->route('forms.show', $form->uuid)->with('message', 'Item excluído com sucesso.');
        }

        public function order($request)
        {
            $aOrder = $request->all();

            try {
                foreach ($aOrder['ordem_atual'] as $order => $section) {
                    $data['order'] = $order;
                    $formSection = $this->formSectionRepository->update($data, $section);
                }

                if(isset($formSection)){
                    $form = $formSection->form;
                    saveVersionForm($form);
                }

            } catch (\Exception $e) {
                return false;
            }
        }
    }
