<?php

namespace App\Service;
use App\Models\Transaction;
use App\Models\Stock;
use Illuminate\Http\JsonResponse;

class TransactionService
{
    public function list(): JsonResponse
    {
        try {
            $transactions = Transaction::all();
            return response()->json([
                'message' => 'All transactions list',
                'data' => $transactions
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error: Failed to find transactions',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Store transaction function
    public function store($user_id, $stock_id, $type, $amount)
    {
        try {
            $stock = Stock::find($stock_id);
            if ($stock) {
                $transaction = new Transaction();
                $transaction->user_id = $user_id;
                $transaction->stock_id = $stock_id;
                $transaction->type = $type;
                $transaction->amount = $amount;
                $transaction->save();
                return response()->json([
                    'message' => 'Transaction created successfully',
                    'data' => $transaction
                ]);
            } else {
                return response()->json([
                    'message' => 'Stock not found',
                    'unavalibale stock' => $stock_id,
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'database_error: Failed to create transaction',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show($id): JsonResponse
    {
        try {
            $transaction = Transaction::find($id);
            if ($transaction) {
                return response()->json([
                    'message' => 'Transaction found',
                    'data' => $transaction
                ]);
            } else {
                return response()->json([
                    'message' => 'Transaction not found',
                    'data' => null
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error: Failed to find transaction',
                'error' => $e->getMessage()
            ], 500);
        }

    }

    public function update($request, $id): JsonResponse
    {
        try {
            $transaction = Transaction::find($id);
            if ($transaction) {
                $transaction->update($request->all());
                return response()->json([
                    'message' => 'Transaction updated successfully',
                    'data' => $transaction
                ]);
            } else {
                return response()->json([
                    'message' => 'Transaction not found',
                    'data' => null
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error: Failed to update transaction',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id): JsonResponse
    {
        try {
            $transaction = Transaction::find($id);
            if ($transaction) {
                $transaction->delete();
                return response()->json([
                    'message' => 'Transaction deleted successfully',
                    'data' => $transaction
                ]);
            } else {
                return response()->json([
                    'message' => 'Transaction not found',
                    'data' => null
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error: Failed to delete transaction',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getTransactionByUser($userId): JsonResponse
    {
        try {
            $transactions = Transaction::where('user_id', $userId)->get();
            return response()->json([
                'message' => 'Transaction found',
                'data' => $transactions
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error: Failed to find transaction',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
