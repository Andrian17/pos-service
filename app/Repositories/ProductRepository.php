<?php

namespace App\Repositories;

use App\Http\Requests\StoreProductRequest;
use App\Http\Resources\ProductCollection;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProductRepository
{
    public function index()
    {
        try {
            return new ProductCollection(Product::with("category")->paginate(20));
        } catch (\Throwable $th) {
            return response()->json([
                "message" => "error",
                "error" => $th->getMessage(),
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
                "message" => "error",
                "error" => $th->getMessage(),
            ]);
        }
    }

    public function create(StoreProductRequest $storeProductRequest)
    {
        try {
            $validator = Validator::make($storeProductRequest->all(), [
                "category_id" => 'required',
                "name" => 'required',
                "stock" => 'required|numeric',
                "price" => 'required|numeric',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    "message" => "Request Invalid",
                    "errors" => $validator->errors()
                ], 400);
            }

            $product = [
                "category_id" => $storeProductRequest->input("category_id"),
                "SKU" => "SKU-" . uniqid(),
                "name" => $storeProductRequest->input("name"),
                "stock" => $storeProductRequest->input("stock"),
                "price" => $storeProductRequest->input("price"),
            ];

            if ($storeProductRequest->hasAny('image')) {
                $product_image = $storeProductRequest->input('image');

                // Image
                $folderPath = "public/products/";
                $formatName = 'productAnd-' . uniqid();
                $imgParts = explode(';base64', $product_image);
                $imgBase64 = base64_decode($imgParts[1]);
                $extension = explode('/', $imgParts[0])[1];
                $fileName = $formatName . '.' . $extension;
                $file = $folderPath . $fileName;

                $product["image"] = $fileName;

                Storage::put($file, $imgBase64);
            }

            $product = Product::create($product);

            return response()->json([
                "message" => "Product has been created",
                "data" => $product
            ], 201);
        } catch (\Throwable $th) {
            return response()->json([
                "message" => "Error",
                "error" => $th->getMessage(),
            ]);
        }
    }

    public function update(Request $updateProductRequest, Product $product)
    {
        try {
            $validator = Validator::make($updateProductRequest->all(), [
                "category_id" => 'required',
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

            $productUpdate = [
                "category_id" => $updateProductRequest->input("category_id"),
                "SKU" => "SKU-" . uniqid(),
                "name" => $updateProductRequest->input("name"),
                "stock" => $updateProductRequest->input("stock"),
                "price" => $updateProductRequest->input("price"),
            ];

            if ($updateProductRequest->hasAny('image')) {
                $product_image = $updateProductRequest->input('image');

                // Image
                $folderPath = "public/products/";
                $formatName = 'productAnd-' . uniqid();
                $imgParts = explode(';base64', $product_image);
                $imgBase64 = base64_decode($imgParts[1]);
                $extension = explode('/', $imgParts[0])[1];
                $fileName = $formatName . '.' . $extension;
                $file = $folderPath . $fileName;

                $productUpdate["image"] = $fileName;

                Storage::put($file, $imgBase64);
            }

            if ($product->image) {
                Storage::delete('public/products/' . $product->image);
            }

            $product->update($productUpdate);

            return response()->json([
                "message" => "Product has been updated",
                "data" => $product
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                "message" => "error",
                "error" => $th->getMessage(),
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
                "message" => "error",
                "error" => $th->getMessage(),
            ]);
        }
    }
}
