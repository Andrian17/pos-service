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
    public function show(Order $order)
    {
        return $this->show($order->uuid);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        return  $this->order->destroy($order->uuid);
    }
}
