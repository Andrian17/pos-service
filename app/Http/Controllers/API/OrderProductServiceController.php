<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\OrderProduct;
use App\Repositories\OrderProductRepository;
use Illuminate\Http\Request;

class OrderProductServiceController extends Controller
{
    protected $orderProduct;
    public function __construct(OrderProductRepository $orderProductRepository)
    {
        $this->orderProduct = $orderProductRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index($rows = null)
    {
        return $this->orderProduct->index($rows);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(OrderProduct $orderProduct)
    {
        return $this->orderProduct->show($orderProduct->id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, OrderProduct $orderProduct)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OrderProduct $orderProduct)
    {
        //
    }
}
