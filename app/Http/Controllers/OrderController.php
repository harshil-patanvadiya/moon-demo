<?php

namespace App\Http\Controllers;

use App\Http\Requests\Order\Store;
use App\Models\Order;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{

    public function __construct(public OrderService $orderService)
    {}
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = $this->orderService->collection();
        return view('orders.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('orders.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Store $request)
    {
        $order = $this->orderService->store($request->validated());
        return response()->json($order, 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(order $order)
    {
        $order = $this->orderService->resource($order);
        return view('orders.show', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        $order = $this->orderService->resource($order);
        return view('orders.create', compact('order'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Store $request, Order $order)
    {
        $order = $this->orderService->update($order, $request->validated());
        return response()->json($order, 200);
    }
}
