<?php

namespace App\Repositories;

use App\Http\Requests\StoreOrderRequest;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class OrderRepository
{

    public function index()
    {
        try {
            $order = Order::with(['order_products.product', "payment"])->get();
            return response()->json([
                "message" => "List Order",
                "data" => $order
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                "message" => "error",
                "error" => $th->getMessage()
            ], 500);
        }
    }

    public function store(StoreOrderRequest $request)
    {
        DB::beginTransaction();
        // 1 Data Order
        $order = [
            "uuid" => uniqid(),
            "user_id" => auth()->user()->id,
            "payment_type_id" => $request->input("payment_type_id"),
            "name" => auth()->user()->name,
            "total_paid" => $request->input("total_paid"),
            "total_price" => null,
            "total_return" => null,
            "receipt_code" => $request->input("receipt_code") ? $request->input("receipt_code") : "OK"
        ];

        $requestProducts = $request->input("products");
        $order_products = [];

        foreach ($requestProducts as $requestProduct) {
            $product = Product::find($requestProduct["product_id"]);

            if ($requestProduct["qty"] > $product->stock) {
                return response()->json(
                    [
                        "message" => "Not enough stock",
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

            // 2. Data OrderProduct
            $order_product = [
                "order_uuid" => $order["uuid"],
                "product_id" => $requestProduct["product_id"],
                "qty" => $requestProduct["qty"],
                "total_price" => $product->price * intval($requestProduct["qty"]),
                "created_at" => now(),
                "updated_at" => now()
            ];

            $order["total_price"] += $order_product["total_price"];
            array_push($order_products, $order_product);
        }

        try {
            if ($order["total_paid"] >= $order["total_price"]) {
                $order["total_return"] = $order["total_paid"] - $order["total_price"];

                Order::create($order);
                OrderProduct::insert($order_products);

                // 3 Response
                $items = collect($order_products);
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
                    "return" => $order["total_return"]
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
            return response()->json(['message' => "error", 'error' => $th->getMessage()], 500);
        }
    }

    public function show($uuid)
    {
        $order = Order::with(["order_products.product", "payment"])->whereUuid($uuid)->first();
        return response()->json([
            "message" => 'Show Order by Uuid',
            "data" => $order
        ], 200);
    }

    public function destroy($uuid)
    {
        try {
            Order::whereUuid($uuid)->first()->delete();
            return response()->json([
                "message" => "Order has been deleted!"
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                "message" => "error",
                "error" => $th->getLine()
            ]);
        }
    }
}
