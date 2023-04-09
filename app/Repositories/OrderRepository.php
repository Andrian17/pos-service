<?php

namespace App\Repositories;

use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class OrderRepository
{

    public function index()
    {
        try {
            $order = Order::with(['order_products', "payment"])->get();
            return response()->json([
                "message" => "List Order",
                "data" => $order
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                "error" => $th->getMessage()
            ], 500);
        }
    }

    public function store($request)
    {
        DB::beginTransaction();
        $order = [
            "uuid" => uniqid(),
            "user_id" => 1,
            "payment_type_id" => $request["payment_type_id"],
            "name" => "Andrian",
            "total_paid" => $request["total_paid"]
        ];
        $total_price = null;

        $requestProducts = $request->input("products");
        $order_products = [];

        foreach ($requestProducts as $requestProduct) {
            $product = Product::find($requestProduct["product_id"]);

            if ($requestProduct["qty"] > $product->stock) {
                return response()->json(
                    [
                        "message" => "Stock unavailable",
                        "data" => [
                            "stock" => $product->stock,
                            "request_stock" => $requestProduct["qty"],
                            "less" => $requestProduct["qty"] - $product->stock
                        ]
                    ]
                );
            }

            $product->stock -= $requestProduct["qty"];
            $product->update();

            $order_product = [
                "order_uuid" => $order["uuid"],
                "product_id" => $requestProduct["product_id"],
                "qty" => $requestProduct["qty"],
                "total_price" => $product->price * intval($requestProduct["qty"]),
                "created_at" => now(),
                "updated_at" => now()
            ];

            $total_price += $order_product["total_price"];
            array_push($order_products, $order_product);
        }

        $order["total_price"] = $total_price;
        $order["receipt_code"] = "OK";
        $order["return"] = $order["total_paid"] - $order["total_price"];

        try {
            if ($total_price <= $order["total_paid"]) {
                $items = collect($order_products);
                Order::create($order);
                OrderProduct::insert($order_products);
                DB::commit();
                return response()->json([
                    "message" => "success",
                    "order_uuid" => $order["uuid"],
                    "purchased_items" => $items->map(function ($item) {
                        $product = Product::find($item["product_id"]);
                        return [
                            "product_id" => $item["product_id"],
                            "name" => $product->name,
                            "price" => $product->price,
                            "qty" => $item["qty"],
                            "total_price" => $item["total_price"],
                        ];
                    }),
                    "total_price" => $order["total_price"],
                    "total_paid" => $order["total_paid"],
                    "return" => $order["return"]
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
            return response()->json(['error' => [
                "message" => $th->getMessage(),
                "line" => $th->getLine(),
                "code" => $th->getCode()
            ]], 500);
        }
    }

    public function show($uuid)
    {
        return Order::with(["order_products", "payment"])->whereUuid($uuid)->first();
    }
}
