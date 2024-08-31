<?php

namespace App\Services;

use App\Http\Requests\StoreOrderRequest;
use App\Models\Order;

class OrderService
{
    public function list()
    {
        return Order::paginate();
    }

    public function store(StoreOrderRequest $request): Order
    {
        return Order::create($request->validated());
    }
}
