<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Repositories\CategoryRepository;
use Illuminate\Http\Request;

class CategoryServiceController extends Controller
{
    protected $category;

    public function __construct(CategoryRepository $category)
    {
        $this->category = $category;
        // header('Access-Control-Allow-Origin: *');
        // header('Access-Control-Allow-Methods: *');
        // header('Access-Control-Allow-Headers: *');
        // header('Content-Type: application/json');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->category->index();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return $this->category->create($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        return $this->category->show($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        return $this->category->update($request->all(), $category->id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        return $this->category->delete($category->id);
    }
}
