<?php

namespace App\Services;

use App\Http\Requests\StoreOrderRequest;
use App\Models\Order;

class OrderService
{
    public function list()
    {
        return auth()->user()->orders()->get();
    }

    public function store(StoreOrderRequest $request): Order
    {
        return Order::create($request->validated());
    }

    public function show(Order $order)
    {
        if ($order->user_id !== auth()->user()->id) {
            return null;
        }

        return auth()->user()->orders()
            ->with(['gtins' => fn($gtins) => $gtins
                ->with(['images' => fn($img) => $img
                    ->select('id', 'url', 'cover', 'gtin_id')
                    ->where('cover', 1)
                    ->limit(1), 'product' => fn($prod) => $prod
                    ->select('id', 'name')])])
            ->where('id', $order->id)
            ->select('id', 'user_id', 'created_at', 'total', 'status', 'bgcolor')
            ->first();
    }
}
