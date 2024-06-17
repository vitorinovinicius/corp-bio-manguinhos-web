<?php

namespace App\Services;

use App\Models\User;
use App\Models\Setor;
use App\Repositories\SetorRepository;
use Carbon\Carbon;

class SetorService
{
    /**
     * occurrenceRepository
     *
     * @var mixed
     */
    private $setorRepository;

    public function __construct(SetorRepository $setorRepository)
    {
        $this->setorRepository = $setorRepository;
    }

    
    public function index()
    {
        $setores = $this->setorRepository->paginate();

		return view('setores.index', compact('setores'));
    }

    public function create()
    {
        return view('setores.create');
    }

    public function store($request)
    {
        $data = $request->all();
        $setor = $this->setorRepository->create($data);

        return redirect()->route('setores.index')->with('message', 'Item criado com sucesso.');
    }
    
    public function show($setor)
    {
        return view('setores.show', compact('setor'));
    }

    public function edit($setor)
    {
        return view('setores.edit', compact('setor'));
    }

    public function update($request, $setor)
    {

        $data = $request->all();

        $setor->update($data);

        return redirect()->back()->with('message', 'Setor atualizado com sucesso.');
    }

    public function destroy($setor)
    {
        
        $setor->delete();

        return redirect()->route('teams.index')->with('message', 'Setor'.$setor->name.'deletada com sucesso.');
    }

}
