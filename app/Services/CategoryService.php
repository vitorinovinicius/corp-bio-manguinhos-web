<?php

namespace App\Services;

use App\Criteria\CategoryCriteria;
use App\Repositories\CategoryRepository;
use App\Repositories\ContractorRepository;

class CategoryService
{
    protected $categoryRepository;
    protected $contractorRepository;

    public function __construct(CategoryRepository $categoryRepository,
        ContractorRepository $contractorRepository
    )
    {
        $this->categoryRepository = $categoryRepository;
        $this->contractorRepository = $contractorRepository;
    }

    public function listCategories()
    {
        $categories = $this->categoryRepository->pushCriteria(new CategoryCriteria())->all();
        return view('categories.index', compact('categories'));
    }

    public function createCategory()
    {
        if (!\Auth::user()->contractor_id) {
            return redirect()->route('categories.index')->with('error', "Apenas empresas têm acesso a criar o item.");
        }

        $contractors = $this->contractorRepository->all();
        return view('categories.create', compact('contractors'));
    }

    public function storeCategory($request)
    {
        if (!\Auth::user()->contractor_id) {
            return redirect()->route('categories.index')->with('error', "Apenas empresas têm acesso a criar o item.");
        }

        $data = $request->all();

        try {
            $this->categoryRepository->create($data);
            return redirect()->route('categories.index')->with('message', "Item criado com sucesso.");
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Não foi possível executar a solicitação.<br>Erro: '.$e->getMessage());
        }
    }

    public function showCategory($category)
    {
        return view('categories.show', compact('category'));
    }

    public function editCategory($category)
    {
        $contractors = $this->contractorRepository->all();
        return view('categories.edit', compact('category', 'contractors'));
    }

    public function updateCategory($request, $category)
    {
        $data = $request->all();

        try{
            $this->categoryRepository->update($data, $category->id);
            return redirect()->route('categories.index')->with('message', 'Item atualizado com sucesso');
        }catch(\Exception $e){
            return redirect()->back()->with('error', 'Não foi possível executar a solicitação.<br>Erro: '.$e->getMessage());
        }
    }

    public function destroyCategory($category)
    {
        try{
            $this->categoryRepository->delete($category->id);
            return redirect()->route('categories.index')->with('message', 'Item excluído com sucesso.');
        }catch(\Exception $e){
            return redirect()->back()->with('error', 'Não foi possível executar a solicitação.<br>Erro: '.$e->getMessage());
        }
    }

    public function get_ajax($request)
    {
        $contractor_id = $request->contractor_id;

        $categories = $this->categoryRepository->pushCriteria(new CategoryCriteria($contractor_id))->all();
        return $categories;
    }
}
