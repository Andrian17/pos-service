<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Models\Product;
use App\Repositories\ProductRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductServiceController extends Controller
{
    protected $products;

    public function __construct(ProductRepository $products)
    {
        $this->products = $products;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->products->index();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        return $this->products->create($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return $this->products->show($product);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        return $this->products->update($id, $request->all());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        return $this->products->delete($id);
    }
}
