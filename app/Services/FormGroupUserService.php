<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 16/11/2017
 * Time: 15:40
 */

namespace App\Services;


use App\Models\Form;
use App\Repositories\FormGroupRepository;
use App\Repositories\FormRepository;
use Exception;

class FormGroupUserService
{
    /**
     * @var FormGroupRepository
     */
    private $formGroupRepository;
    /**
     * @var FormRepository
     */
    private $formRepository;

    /**
     * FormGroupService constructor.
     * @param FormGroupRepository $formGroupRepository
     * @param FormRepository $formRepository
     */
    public function __construct(
        FormGroupRepository $formGroupRepository,
        FormRepository $formRepository
    )
    {
        $this->formGroupRepository = $formGroupRepository;
        $this->formRepository = $formRepository;
    }


    public function create(Form $form)
    {
        return view('form_groups.user.create',compact('form'));
    }

    public function store($request)
    {
        $data = $request->all();

        $form = $this->formRepository->find($data['form_id']);

        try {
            $this->formGroupRepository->create($data);
        } catch (Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Erro ao tentar salvar o item. <br>Erro: '.$e->getMessage());
        }

        return redirect()->route('forms.show_user', $form->uuid)->with('message', 'Item atualizado com sucesso.');
    }

    public function edit($form_group)
    {
        $form = $form_group->form;
        return view('form_groups.user.edit', compact('form_group','form'));
    }

    public function update($form_group, $request)
    {
        $data = $request->all();
        $form = $form_group->form;

        try {
            $this->formGroupRepository->update($data, $form_group->id);
        } catch (Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Erro ao tentar editar o item. <br>Erro: '.$e->getMessage());
        }

        return redirect()->route('forms.show_user', $form->uuid)->with('message', 'Item atualizado com sucesso.');
    }
}