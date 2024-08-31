<?php

namespace App\Services;

use App\Http\Requests\StoreDeliveryMethodRequest;
use App\Http\Requests\UpdateDeliveryMethodRequest;
use App\Models\DeliveryMethod;

class DeliveryMethodService
{
    public function list()
    {
        return DeliveryMethod::select(['id', 'name'])
            ->paginate();
    }

    public function store(StoreDeliveryMethodRequest $request): DeliveryMethod
    {
        return DeliveryMethod::create($request->validated());
    }

    public function update(UpdateDeliveryMethodRequest $request, DeliveryMethod $deliveryMethod): DeliveryMethod
    {
        $deliveryMethod->update($request->validated());

        return $deliveryMethod;
    }

    public function destroy(DeliveryMethod $deliveryMethod): ?bool
    {
        return $deliveryMethod->delete();
    }
}
