<?php

namespace App\Repositories;

use App\Http\Resources\CategoryCollection;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Support\Facades\Validator;

class CategoryRepository
{

    public function index()
    {
        try {
            return response()->json(new CategoryCollection(Category::with("products")->get()), 200);
        } catch (\Throwable $th) {
            return response()->json([
                "message" => "error",
                "error" => $th->getMessage()
            ]);
        }
    }

    public function show($id)
    {
        $category = Category::with("products")->findOrFail($id);
        return response()->json(
            [
                "message" => "success",
                "data" => $category
            ],
            200
        );
    }

    public function create($data)
    {
        try {
            $validator = Validator::make($data, [
                "name" => "required"
            ]);
            if ($validator->fails()) {
                return response()->json([
                    "message" => "Request Invalid",
                    "data" => $validator->errors()
                ], 400);
            }
            $category = Category::create($data);
            return response()->json([
                "message" => "Category has been created",
                "data" => $category
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                "message" => "error",
                "error" => $th->getMessage()
            ]);
        }
    }

    public function update($data, $id)
    {
        try {
            $validator = Validator::make($data, [
                "name" => "required"
            ]);
            if ($validator->fails()) {
                return response()->json([
                    "message" => "Request Invalid",
                    "data" => $validator->errors()
                ], 400);
            }
            $category = Category::with("products")->findOrFail($id)->update($data);
            return response()->json([
                "message" => "Category has been updated",
                "data" => $category
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                "message" => "error",
                "error" => $th->getMessage()
            ], 404);
        }
    }

    public function delete($id)
    {
        try {
            Category::destroy($id);
            return response()->json([
                "message" => "Category has been deleted!",
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                "message" => "error",
                "error" => $th->getMessage()
            ], 404);
        }
    }
}
