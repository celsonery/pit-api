<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDeliveryMethodRequest;
use App\Http\Requests\UpdateDeliveryMethodRequest;
use App\Models\DeliveryMethod;
use App\Services\DeliveryMethodService;
use Illuminate\Http\JsonResponse;

class DeliveryMethodController extends Controller
{
    public function __construct(protected DeliveryMethodService $deliveryMethodService)
    {
    }

    public function index(): JsonResponse
    {
        $deliveryMethods = $this->deliveryMethodService->list();

        return response()->json($deliveryMethods);
    }

    public function store(StoreDeliveryMethodRequest $request): JsonResponse
    {
        return DeliveryMethod::create($request->validated());
    }

    public function show(DeliveryMethod $delivery): JsonResponse
    {
        return response()->json($delivery);
    }

    public function update(UpdateDeliveryMethodRequest $request, DeliveryMethod $delivery): JsonResponse
    {
        $delivery = $this->deliveryMethodService->update($request, $delivery);

        return response()->json($delivery);
    }

    public function destroy(DeliveryMethod $delivery): JsonResponse
    {
        $this->deliveryMethodService->destroy($delivery);

        return response()->json(['message' => 'Delivery method deleted!']);
    }
}
