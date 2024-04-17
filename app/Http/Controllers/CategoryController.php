<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Service\CategoryService;


class CategoryController extends Controller
{
    protected $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function list() {
        $response = $this->categoryService->list();
        return $response;
    }

    public function store(CategoryRequest $request) {
        $response = $this->categoryService->store($request->all());
        return $response;
    }

    public function show($id) {
        $response = $this->categoryService->show($id);
        return $response;
    }

    public function update(CategoryRequest $request, $id) {
        $response = $this->categoryService->update($id, $request->all());
        return $response;
    }

    public function destroy($id) {
        $response = $this->categoryService->destroy($id);
        return $response;
    }
}
