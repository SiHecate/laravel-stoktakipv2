<?php

namespace App\Http\Controllers;

use App\Http\Requests\StockRequest;
use App\Service\StockService;
use Illuminate\Http\Request;

class StockController extends Controller
{
    protected $stockService;

    public function __construct(StockService $stockService)
    {
        $this->stockService = $stockService;
    }

    public function list()
    {
        $response = $this->stockService->list();
        return $response;
    }

    public function store(StockRequest $request)
    {
        $response = $this->stockService->store($request->all());
        return $response;
    }

    public function search(Request $request)
    {
        $data = $request->all();
        $response = $this->stockService->search($data);
        return $response;
    }

    public function update(Request $request)
    {
        $id = $request->input('id');
        $response = $this->stockService->update($id, $request->all());
        return $response;
    }

    public function destroy($id)
    {
        $response = $this->stockService->destroy($id);
        return $response;
    }

    public function show($id)
    {
        $response = $this->stockService->show($id);
        return $response;
    }

    public function increase(Request $request, $id)
    {
        $user_id = $request->user()->id;
        $specialAmount = $request->has('specialAmount') ? $request->input('specialAmount') : null;
        $response = $this->stockService->increase($user_id,$id, $specialAmount);
        return $response;
    }

    public function decrease(Request $request, $id)
    {
        $user_id = $request->user()->id;
        $specialAmount = $request->has('specialAmount') ? $request->input('specialAmount') : null;
        $response = $this->stockService->decrease($user_id,$id, $specialAmount);
        return $response;
    }
}
