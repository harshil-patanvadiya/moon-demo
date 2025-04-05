<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class OrderService
{
    private $orderObj;
    private $productObj;

    public function __construct()
    {
        $this->orderObj = new Order();
        $this->productObj = new Product();
    }

    public function collection()
    {
        return $this->orderObj->where('user_id', Auth::id())->orderBy('id', 'DESC')->paginate(10);
    }

    public function resource(Order $order)
    {
        return $this->orderObj->with('products')->where('user_id', Auth::id())->where('id', $order->id)->first();
        
    }

    public function store(array $input)
    {
        $order = $this->orderObj->create([
            'customer_name' => $input['customer_name'],
            'user_id' => Auth::id()
        ]);
        $total = 0;
        
        foreach ($input['products'] as $product) {
            $this->productObj->create([
                'order_id' => $order->id,
                'name' => $product['name'],
                'quantity' => $product['quantity'],
                'amount' => $product['amount'],
                'total' => $product['amount'] * $product['quantity'],
            ]);

            $total += $product['amount'] * $product['quantity'];
        }

        $order->update([
            'total' => $total
        ]);

        $data = [
            'message' => 'Order created successfully.',
        ];

        return $data;
    }

    public function update(Order $order, array $input)
    {
        $order->update([
            'customer_name' => $input['customer_name'],
        ]);

        $order->products()->delete();

        $total = 0;
        
        foreach ($input['products'] as $product) {
            $this->productObj->create([
                'order_id' => $order->id,
                'name' => $product['name'],
                'quantity' => $product['quantity'],
                'amount' => $product['amount'],
                'total' => $product['amount'] * $product['quantity'],
            ]);

            $total += $product['amount'] * $product['quantity'];
        }

        $order->update([
            'total' => $total
        ]);

        $data = [
            'message' => 'Order updated successfully.',
            'is_updated' => true,
        ];

        return $data;
    }

}