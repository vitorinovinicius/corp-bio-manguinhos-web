<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 16/11/2017
 * Time: 15:40
 */

namespace App\Services;


use App\Repositories\ExempleRepository;
use Exception;

class ExempleService
{
    /**
     * @var ExempleRepository
     */
    private $exempleRepository;

    /**
     * ExempleService constructor.
     */
    public function __construct(
        ExempleRepository $exempleRepository
    )
    {
        $this->exempleRepository = $exempleRepository;
    }

    public function index()
    {
        $exemples = $this->exempleRepository->paginate();

        return view('exemples.index', compact('exemples'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('exemples.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store($request)
    {
        $data = $request->all();
        try {
            $this->exempleRepository->create($data);
        } catch (Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Erro ao tentar salvar o item. <br>Erro: '.$e->getMessage());
        }

        return redirect()->route('exemples.index')->with('message', 'Item criado com sucesso.');
    }


    public function show($exemple)
    {
        return view('exemples.show', compact('exemple'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($exemple)
    {
        return view('exemples.edit', compact('exemple'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @param Request $request
     * @return Response
     */
    public function update($exemple, $request)
    {
        $data = $request->all();

        try {
            $this->exempleRepository->update($data, $exemple->id);
        } catch (Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Erro ao tentar editar o item. <br>Erro: '.$e->getMessage());
        }

        return redirect()->route('exemples.index')->with('message', 'Item atualizado com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($exemple)
    {
        try {
            $exemple->delete();
        } catch (Exception $e) {
            return redirect()->route('exemples.index')->with('error', 'Erro ao tentar excluir o item. <br>Erro: '.$e->getMessage());
        }
        return redirect()->route('exemples.index')->with('message', 'Item deletado com sucesso.');
    }
}