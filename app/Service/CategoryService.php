<?php

namespace App\Service;

use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Database\QueryException;

class CategoryService
{
    public function list(): JsonResponse
    {
        try {
            $categories = Category::all();

            return response()->json([
                'message' => 'All category list',
                'data' => $categories,
            ]);
        } catch (QueryException $e) {
            return response()->json([
                'message' => 'Error: Failed to find categories',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function store(array $data): JsonResponse
    {
        try {
            $category = Category::create($data);

            return response()->json([
                'message' => 'Category created successfully',
                'data' => $category
            ]);
        } catch (QueryException $e) {
            return response()->json([
                'message' => 'Error: Failed to create category',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show($id): JsonResponse
    {
        try {
            $category = Category::find($id);

            if ($category) {
                return response()->json([
                    'data' => $category,
                ]);
            } else {
                return response()->json([
                    'message' => 'Error: Category not found',
                ], 404);
            }
        } catch (QueryException $e) {
            return response()->json([
                'message' => 'Error: Failed to find category',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    public function findById($id) {
        $category = Category::find($id);
        if($category) {
            return $category->name;
        } else {
            return null;
        }
    }

    public function update($id, array $data): JsonResponse
    {
        try {
            $category = Category::find($id);

            if ($category) {
                $category->update($data);

                return response()->json([
                    'message' => 'Category updated successfully',
                    'data' => $category
                ]);
            } else {
                return response()->json([
                    'message' => 'Error: Category not found',
                ], 404);
            }
        } catch (QueryException $e) {
            return response()->json([
                'message' => 'Error: Failed to update category',
                'error' => $e->getMessage()
            ], 500);
        }
    }



    public function destroy($id): JsonResponse
    {
        try {
            $category = Category::find($id);
            if ($category) {
                $category->delete();
                return response()->json([
                    'message' => 'Category deleted successfully',
                    'category' => $category,
                ]);
            } else {
                return response()->json([
                    'message' => 'Error: Category not found',
                ], 404);
            }
        } catch (QueryException $e) {
            return response()->json([
                'message' => 'Error: Failed to delete category',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
