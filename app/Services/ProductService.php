<?php

namespace App\Services;

use App\Criteria\CategoryCriteria;
use App\Criteria\ProductCriteria;
use App\Repositories\CategoryRepository;
use App\Repositories\ContractorRepository;
use App\Repositories\ProductRepository;

class ProductService
{
    protected $productRepository;
    protected $contractorRepository;
    protected $categoryRepository;

    public function __construct(
        ProductRepository $productRepository,
        ContractorRepository $contractorRepository,
        CategoryRepository $categoryRepository
    )
    {
        $this->productRepository = $productRepository;
        $this->contractorRepository = $contractorRepository;
        $this->categoryRepository = $categoryRepository;
    }

    public function listProducts()
    {
        $products = $this->productRepository->pushCriteria(new ProductCriteria())->all();
        return view('products.index', compact('products'));
    }

    public function createProduct()
    {
        if(!\Auth::user()->contractor_id) {
            return redirect()->route('products.index')->with('error', "Apenas empresas podem cadastrar items.");
        }

        $contractors = $this->contractorRepository->all();
        $categories = $this->categoryRepository->pushCriteria(new CategoryCriteria())->where(["status"=>1])->get();

        return view('products.create', compact('contractors', 'categories'));
    }

    public function storeProduct($request)
    {
        $data = $request->all();

        if(!\Auth::user()->contractor_id) {
            return redirect()->route('products.index')->with('error', "Usuário sem empreiteira associada.");
        }

        try {
            $data['value'] = str_replace(',', '.', $data['value']);
            $product = $this->productRepository->create($data);
            if(isset($data['categories']) && !empty($data['categories'])){
                $product->categories()->sync($data['categories']);
            }
            return redirect()->route('products.index')->with('message', "Item criado com sucesso.");
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Não foi possível executar a solicitação.<br>Erro: '.$e->getMessage());
        }
    }

    public function showProduct($product)
    {
        return view('products.show', compact('product'));
    }

    public function editProduct($product)
    {
        $contractor_id = $product->contractor_id;

        $contractors = $this->contractorRepository->all();
        $categories = $this->categoryRepository->pushCriteria(new CategoryCriteria( $contractor_id))->where(["status"=>1])->get();

        return view('products.edit', compact('product', 'contractors', 'categories'));
    }

    public function updateProduct($request, $product)
    {
        $data = $request->all();

        if(!\Auth::user()->contractor_id) {
            return redirect()->route('products.index')->with('error', "Usuário sem empreiteira associada.");
        }

        try {
            $data['value'] = str_replace(',', '.', $data['value']);
            $this->productRepository->update($data, $product->id);
            if(isset($data['categories']) && !empty($data['categories'])){
                $product->categories()->sync($data['categories']);
            }else{
                $product->categories()->sync([]);
            }
            return redirect()->route('products.index')->with('message', "Item atualizado com sucesso.");
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Não foi possível executar a solicitação.<br>Erro: '.$e->getMessage());
        }
    }

    public function destroyProduct($product)
    {
        try{
            $this->productRepository->delete($product->id);
            return redirect()->route('products.index')->with('message', 'Item excluído com sucesso.');
        }catch(\Exception $e){
            return redirect()->back()->with('error', 'Não foi possível executar a solicitação.<br>Erro: '.$e->getMessage());
        }
    }
}
