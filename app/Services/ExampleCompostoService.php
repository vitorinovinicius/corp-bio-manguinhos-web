<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 16/11/2017
 * Time: 15:40
 */

namespace App\Services;


use App\Repositories\ExampleCompostoRepository;
use Exception;
use Prettus\Repository\Criteria\RequestCriteria;

class ExampleCompostoService
{
    /**
     * @var ExampleCompostoRepository
     */
    private $exampleCompostoRepository;

    /**
     * ExampleCompostoService constructor.
     * @param ExampleCompostoRepository $exampleCompostoRepository
     */
    public function __construct(
        ExampleCompostoRepository $exampleCompostoRepository
    )
    {
        $this->exampleCompostoRepository = $exampleCompostoRepository;
    }

    public function index($request)
    {
        $this->exampleCompostoRepository->pushCriteria(new RequestCriteria($request));
        $example_compostos = $this->exampleCompostoRepository->paginate();

        return view('example_compostos.index', compact('example_compostos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('example_compostos.create');
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
            $this->exampleCompostoRepository->create($data);
        } catch (Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Erro ao tentar salvar o item. <br>Erro: '.$e->getMessage());
        }

        return redirect()->route('example_compostos.index')->with('message', 'Item criado com sucesso.');
    }


    public function show($example_composto)
    {
        return view('example_compostos.show', compact('example_composto'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($example_composto)
    {
        return view('example_compostos.edit', compact('example_composto'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @param Request $request
     * @return Response
     */
    public function update($example_composto, $request)
    {
        $data = $request->all();

        try {
            $this->exampleCompostoRepository->update($data, $example_composto->id);
        } catch (Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Erro ao tentar editar o item. <br>Erro: '.$e->getMessage());
        }

        return redirect()->route('example_compostos.index')->with('message', 'Item atualizado com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($exampleComposto)
    {
        try {
            $exampleComposto->delete();
        } catch (Exception $e) {
            return redirect()->route('example_compostos.index')->with('error', 'Erro ao tentar excluir o item. <br>Erro: '.$e->getMessage());
        }
        return redirect()->route('example_compostos.index')->with('message', 'Item deletado com sucesso.');
    }
}