<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 16/11/2017
 * Time: 15:40
 */

namespace App\Services;

use App\Criteria\SkillSelectCriteria;
use App\Repositories\SkillRepository;
use Exception;

class SkillService
{
    /**
     * @var SkillRepository
     */
    private $skillRepository;

    /**
     * SkillService constructor.
     */
    public function __construct(
        SkillRepository $skillRepository
    )
    {
        $this->skillRepository = $skillRepository;
    }

    public function index()
    {
        $skills = $this->skillRepository->pushCriteria(new SkillSelectCriteria())->paginate();

        return view('skills.index', compact('skills'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        if (!\Auth::user()->contractor_id) {
            return redirect()->route('skills.index')->with('error', "Apenas empresas têm acesso a criar o item.");
        }

        return view('skills.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store($request)
    {
        if (!\Auth::user()->contractor_id) {
            return redirect()->route('skills.index')->with('error', "Apenas empresas têm acesso a criar o item.");
        }

        $data = $request->all();

        try {
            $this->skillRepository->create($data);
        } catch (Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Erro ao tentar salvar o item. <br>Erro: '.$e->getMessage());
        }

        return redirect()->route('skills.index')->with('message', 'Item criado com sucesso.');
    }


    public function show($skill)
    {
        return view('skills.show', compact('skill'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($skill)
    {
        return view('skills.edit', compact('skill'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @param Request $request
     * @return Response
     */
    public function update($skill, $request)
    {
        $data = $request->all();

        try {
            $this->skillRepository->update($data, $skill->id);
        } catch (Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Erro ao tentar editar o item. <br>Erro: '.$e->getMessage());
        }

        return redirect()->route('skills.index')->with('message', 'Item atualizado com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($skill)
    {
        try {
            $skill->delete();
        } catch (Exception $e) {
            return redirect()->route('skills.index')->with('error', 'Erro ao tentar excluir o item. <br>Erro: '.$e->getMessage());
        }
        return redirect()->route('skills.index')->with('message', 'Item deletado com sucesso.');
    }
}
