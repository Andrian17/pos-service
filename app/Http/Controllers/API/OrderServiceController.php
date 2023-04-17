<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Repositories\OrderRepository;
use Illuminate\Http\Request;

class OrderServiceController extends Controller
{
    protected $order;

    public function __construct(OrderRepository $orderRepository)
    {
        $this->order = $orderRepository;
        // $this->middleware('admin');
        // $this->middleware('user', ['only' => ['show', 'index']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->order->index();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return $this->order->store($request);
    }

    /**
     * Display the specified resource.
     */
    public function show($order)
    {
        return $this->order->show($order);
        // return response()->json(["data" => "OK"]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($order)
    {
        return  $this->order->destroy($order);
    }
}
