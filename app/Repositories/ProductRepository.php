<?php

namespace App\Repositories;

use App\Http\Resources\ProductCollection;
use App\Models\Product;
use Illuminate\Support\Facades\Validator;

class ProductRepository
{
    public function index()
    {
        try {
            return new ProductCollection(Product::with("category")->paginate(10));
        } catch (\Throwable $th) {
            throw $th;
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
            throw $th;
        }
    }

    public function create($data)
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
            $product = Product::create($data);
            return response()->json([
                "message" => "Product has been created",
                "data" => $product
            ], 201);
        } catch (\Throwable $th) {
            throw $th;
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
            throw $th;
        }
    }

    public function delete($id)
    {
        try {
            $product = Product::destroy($id);
            return response()->json([
                "message" => "Product has been deleted!",
                "data" => $product
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
