<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 16/11/2017
 * Time: 15:40
 */

namespace App\Services;


use App\Models\Form;
use App\Repositories\FormRepository;
use App\Repositories\OccurrenceTypeRepository;
use Exception;

class FormUserService
{
    /**
     * @var FormRepository
     */
    private $formRepository;
    /**
     * @var OccurrenceTypeRepository
     */
    private $occurrenceTypeRepository;

    /**
     * FormService constructor.
     * @param FormRepository $formRepository
     * @param OccurrenceTypeRepository $occurrenceTypeRepository
     */
    public function __construct(
        FormRepository $formRepository,
        OccurrenceTypeRepository $occurrenceTypeRepository
    )
    {
        $this->formRepository = $formRepository;
        $this->occurrenceTypeRepository = $occurrenceTypeRepository;
    }

    public function create()
    {
        return view('forms.user.create');
    }

    public function store($request)
    {
        $data = $request->all();
        try {
           
            $form = $this->formRepository->create($data);

            saveVersionForm($form);
        } catch (Exception $e) {
            return redirect()->back()->withInput()->with('error_form', 'Erro ao tentar salvar o item. <br>Erro: '.$e->getMessage());
        }

        return redirect()->route('forms.show_user', $form->uuid)->with('message_form', 'Item criado com sucesso.');
    }

    public function edit($form)
    {
        return view('forms.user.edit', compact('form'));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param $form
     * @param Request $request
     * @return Response
     */
    public function update($form, $request)
    {
        $data = $request->all();

        try {
            $form = $this->formRepository->update($data, $form->id);

            if(count($form->getChanges())) {
                saveVersionForm($form);
            }

        } catch (Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Erro ao tentar editar o item. <br>Erro: '.$e->getMessage());
        }

        return redirect()->route('forms.index')
            ->with('message', 'Item atualizado com sucesso.');
    }
    public function show(Form $form)
    {
        return view('forms.user.show', compact('form'));
    }
}
