<?php

namespace App\Repositories;

use App\Models\OrderProduct;

class OrderProductRepository
{

    public function index($rows = 20)
    {
        $orderProducts = OrderProduct::with(['order', 'product'])->latest()->paginate($rows);
        return response()->json([
            "message" => "success",
            "data" => $orderProducts
        ]);
    }

    public function show($orderProductID)
    {
        $orderProduct = OrderProduct::find($orderProductID);
        return response()->json([
            "message" => "success",
            "data" => $orderProduct
        ]);
    }
}
