<?php

namespace App\Service;

use App\Models\Stock;
use Illuminate\Database\QueryException;
use Illuminate\Http\Client\Request;
use Illuminate\Http\JsonResponse;

class StockService
{
    public function list(): JsonResponse {
        try {
            $stock = Stock::all();
            return response()->json([
                'message' => 'All stock list',
                'data' => $stock
            ]);
        } catch (QueryException $e) {
            return response()->json([
                'message' => 'Error: Failed to find stocks',
                'error' => $e->getMessage(),
            ]);
        }
    }

    public function store(array $data): JsonResponse {
        try {
            $stock = Stock::create($data);
            $category = $stock->category;
            if ($category !== null) {
                return response()->json([
                    'message' => 'Stock created successfully',
                    'data' => $stock,
                ]);
            } else {
                return response()->json([
                    'message' => 'Category not found for the given category_id',
                    'category_id' => $data['category_id'],
                ]);
            }
        } catch (QueryException $e) {
            return response()->json([
                'message' => 'Error: Failed to create stock',
                'error' => $e->getMessage(),
            ]);
        }
    }

    public function search($data): JsonResponse {
        try {
            $stock = Stock::find($data);
            if ($stock) {
                return response()->json([
                    'data' => $stock
                ]);
            } else {
                return response()->json([
                    'error' => 'stock cannot find in database'
                ]);
            }
        } catch (QueryException $e) {
            return response()->json([
                'message' => 'Error: Failed to find spesific stock',
                'error' => $e->getMessage(),
            ]);
        }
    }

    public function update($id, array $data): JsonResponse {
        try {
            $stock = Stock::find($id);
            if ($stock) {
                $stock->update($data);

            }
            return response()->json([
                'message' => 'Category updated successfully',
                'data' => $stock
            ]);

        } catch (QueryException $e) {
            return response()->json([
                'message' => 'Error: Failed to update stock',
                'error' => $e->getMessage(),
            ]);
        }
    }

    public function destroy($id): JsonResponse {
        try {
            $stock = Stock::find($id);
            if ($stock) {
                $stock->delete();
                return response()->json([
                    'message' => 'stock deleted successfully',
                    'data' => $stock,
                ]);
            } else {
                return response()->json([
                    'message' => 'Error: stock not found',
                ], 404);
            }
        } catch (QueryException $e) {
            return response()->json([
                'message' => 'Error: Failed to delete stock',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function show($id): JsonResponse {
        try {
            $stock = Stock::find($id);
            return response()->json([
                'message' => 'Stock find successfuly'
            ]);
        } catch (QueryException $e) {
            return response()->json([
                'message' => 'Error: Failed to find stock',
                'error' => $e->getMessage(),
            ]);
        }
    }

    public function getStock($id) {
        try {
            $stock = Stock::first($id);
            return $stock;
        } catch (QueryException $e) {
            return $e->getMessage();
        }
    }

    // Stock id'sinden stockların özelliği alınacak bu sayede transaction işlemi yapılabilecek.
    public function increase($user_id, $id, $specialAmount): JsonResponse {
        try {
            $stock = Stock::find($id);
            if ($specialAmount != null ){
                if ($stock) {
                    $stock->stock += 1;
                    $stock->save();
                    $current_stock = $stock->stock;
                    $stock->transaction()->create([
                        'user_id' => $user_id,
                        'stock_id' => $stock->id,
                        'type' => 'Stock Increase',
                        'amount' => $current_stock,
                    ]);
                    return response()->json(['success' => true, 'message' => 'Stock quantity increased'], 200);
                } else {
                    return response()->json(['success' => false, 'message' => 'Stock not found'], 404);
                }
            } else {
                if ($stock) {
                    $stock->stock += $specialAmount;
                    $stock->save();
                    return response()->json(['success' => true, 'message' => 'Stock quantity increased', 'Stock added' => $specialAmount], 200);
                } else {
                    return response()->json(['success' => false, 'message' => 'Stock not found'], 404);
                }
            }
        } catch (QueryException $e) {
            return response()->json(['success' => false, 'message' => 'An error occurred while increasing stock quantity'], 500);
        }
    }

    public function decrease($user_id ,$id, $specialAmount): JsonResponse {
        try {
            $stock = Stock::find($id);
            if ($specialAmount != null ){
                if ($stock) {
                    $stock->stock -= 1;
                    $stock->save();
                    $current_stock = $stock->stock;
                    $stock->transaction()->create([
                        'user_id' => $user_id,
                        'stock_id' => $stock->id,
                        'type' => 'Stock Decrease',
                        'amount' => $current_stock,
                    ]);
                    return response()->json(['success' => true, 'message' => 'Stock quantity decreased'], 200);
                } else {
                    return response()->json(['success' => false, 'message' => 'Stock not found'], 404);
                }
            } else {
                if ($stock) {
                    $stock->stock -= $specialAmount;
                    $stock->save();
                    return response()->json(['success' => true, 'message' => 'Stock quantity decreased', 'Stock removed' => $specialAmount], 200);
                } else {
                    return response()->json(['success' => false, 'message' => 'Stock not found'], 404);
                }
            }
        } catch (QueryException $e) {
            return response()->json(['success' => false, 'message' => 'An error occurred while decreasing stock quantity'], 500);
        }
    }
}
