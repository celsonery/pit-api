<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Models\Order;
use App\Services\OrderService;
use Illuminate\Database\Eloquent\Casts\Json;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

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

    public function store(Request $request): JsonResponse
    {
        $order = $this->orderService->store($request->all());

        return response()->json($order);
    }

    public function show(Order $order): JsonResponse
    {
        $order = $this->orderService->show($order);

        return response()->json($order);
    }
}
