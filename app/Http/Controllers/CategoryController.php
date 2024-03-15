<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use Illuminate\Http\Request;
use App\Services\CategoryService;
use App\Models\Category;

class CategoryController extends Controller
{
    private $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function index()
    {        
        return $this->categoryService->listCategories();
    }

    public function create()
    {
        return $this->categoryService->createCategory();
    }

    public function store(CategoryRequest $request)
    {
        return $this->categoryService->storeCategory($request);
    }

    public function show(Category $category)
    {
        return $this->categoryService->showCategory($category);
    }

    public function edit(Category $category)
    {
        return $this->categoryService->editCategory($category);
    }

    public function update(CategoryRequest $request, Category $category)
    {
        return $this->categoryService->updateCategory($request, $category);
    }

    public function destroy(Category $category)
    {
        return $this->categoryService->destroyCategory($category);
    }

    public function get_ajax(Request $request)
    {
        return $this->categoryService->get_ajax($request);
    }
}
