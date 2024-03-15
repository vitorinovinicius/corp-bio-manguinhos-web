<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Services\ProductService;
use App\Models\Product;
class ProductController extends Controller
{
    private $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index()
    {
        return $this->productService->listProducts();
    }

    public function create()
    {
       return $this->productService->createProduct();
    }

    public function store(ProductRequest $request)
    {
        return $this->productService->storeProduct($request);
    }

    public function show(Product $product)
    {
        return $this->productService->showProduct($product);
    }

    public function edit(Product $product)
    {
        return $this->productService->editProduct($product);
    }

    public function update(ProductRequest $request, Product $product)
    {
        return $this->productService->updateProduct($request, $product);
    }

    public function destroy(Product $product)
    {
        return $this->productService->destroyProduct($product);
    }

}
