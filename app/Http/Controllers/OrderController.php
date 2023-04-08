<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Models\OrderProduct;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrderRequest $request)
    {
        DB::beginTransaction();
        $order = [
            "uuid" => uniqid(),
            "user_id" => 1,
            "payment_type_id" => $request->input("payment_type_id"),
            "name" => "Andrian",
            "total_paid" => $request->input("total_paid")
        ];
        $total_price = null;

        $requestProducts = $request->input("product_id");
        $order_products = [];
        for ($i = 0; $i < count($requestProducts) - 1; $i++) {
            $product = Product::find($requestProducts[$i]);
            $order_product = [
                "order_uuid" => $order["uuid"],
                "product_id" => $requestProducts[$i],
                "qty" => $request->input("qty")[$i],
                "total_price" => $product->price * intval($request->input("qty")[$i]),
                "created_at" => now(),
                "updated_at" => now()
            ];
            $total_price += $order_product["total_price"];
            array_push($order_products, $order_product);
        }
        $order["total_price"] = $total_price;
        $order["receipt_code"] = "OK";
        try {
            if ($total_price < $order["total_paid"]) {
                Order::create($order);
                OrderProduct::insert($order_products);
                DB::commit();
                return response()->json([
                    "message" => "success",
                    "total_price" => $order["total_price"],
                    "total_paid" => $order["total_paid"],
                    "return" => $order["total_paid"] - $order["total_price"]
                ]);
            }
            return response()->json([
                "message" => "Price greater than Paid!",
                "data" => [
                    "total_price" => $order["total_price"],
                    "total_paid" => $order["total_paid"],
                    "less" => $order["total_price"] - $order["total_paid"]
                ]
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrderRequest $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }
}
