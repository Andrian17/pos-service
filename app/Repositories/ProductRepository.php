<?php

namespace App\Repositories;

use App\Http\Requests\StoreProductRequest;
use App\Http\Resources\ProductCollection;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductRepository
{
    public function index()
    {
        try {
            return new ProductCollection(Product::with("category")->paginate(20));
        } catch (\Throwable $th) {
            return response()->json([
                "message" => "Error",
                "error" => [
                    "message" => $th->getMessage(),
                    "line" => $th->getLine()
                ]
            ]);
        }
    }

    public function show($product)
    {
        try {
            return response()->json([
                "message" => "showing product with id $product->id",
                "data" => $product
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                "message" => "Error",
                "error" => [
                    "message" => $th->getMessage(),
                    "line" => $th->getLine()
                ]
            ]);
        }
    }

    public function create(StoreProductRequest $storeProductRequest)
    {
        try {
            $product = [
                "category_id" => $storeProductRequest->input("category_id"),
                "SKU" => $storeProductRequest->input("SKU"),
                "name" => $storeProductRequest->input("name"),
                "stock" => $storeProductRequest->input("stock"),
                "price" => $storeProductRequest->input("price"),
            ];

            $validator = Validator::make($storeProductRequest->all(), [
                "category_id" => 'required',
                "SKU" => 'required|unique:products',
                "name" => 'required',
                "stock" => 'required|numeric',
                "price" => 'required|numeric',
            ]);

            $product_image = $storeProductRequest->file('image');
            $fileName = 'product-' . uniqid() . '.' . $product_image->clientExtension();
            $product_image->storeAs('public/products', $fileName);
            $product["image"] = $fileName;

            if ($validator->fails()) {
                return response()->json([
                    "message" => "Request Invalid",
                    "errors" => $validator->errors()
                ], 400);
            }

            $product = Product::create($product);
            return response()->json([
                "message" => "Product has been created",
                "data" => $product
            ], 201);
        } catch (\Throwable $th) {
            return response()->json([
                "message" => "Error",
                "error" => [
                    "message" => $th->getMessage(),
                    "line" => $th->getLine()
                ]
            ]);
        }
    }

    public function update($id, $data)
    {
        try {
            $validator = Validator::make($data, [
                "category_id" => 'required',
                "SKU" => 'required|unique:products',
                "name" => 'required',
                "stock" => 'required|numeric',
                "price" => 'required|numeric',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    "message" => "Request Invalid",
                    "data" => $validator->errors()
                ], 400);
            }
            $product =  Product::find($id)->update($data);

            return response()->json([
                "message" => "Product has been updated",
                "data" => $product
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                "message" => "Error",
                "error" => [
                    "message" => $th->getMessage(),
                    "line" => $th->getLine()
                ]
            ]);
        }
    }

    public function delete($id)
    {
        try {
            Product::destroy($id);
            return response()->json([
                "message" => "Product has been deleted!",
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                "message" => "Error",
                "error" => [
                    "message" => $th->getMessage(),
                    "line" => $th->getLine()
                ]
            ]);
        }
    }
}
