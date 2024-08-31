<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Models\Order;
use App\Services\OrderService;
use Illuminate\Http\JsonResponse;

class OrderController extends Controller
{
    public function __construct(protected OrderService $orderService)
    {
    }

    public function index(): JsonResponse
    {
        $orders = $this->orderService->list();

        return response()->json($orders);
    }

    public function show(Order $order)
    {
        return response()->json($order);
    }
}
