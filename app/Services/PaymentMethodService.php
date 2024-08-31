<?php

namespace App\Services;

use App\Http\Requests\StorePaymentMethodRequest;
use App\Http\Requests\UpdatePaymentMethodRequest;
use App\Models\PaymentMethod;

class PaymentMethodService
{
    public function list()
    {
        return PaymentMethod::select(['id', 'name', 'icon'])
            ->paginate();
    }

    public function store(StorePaymentMethodRequest $request): PaymentMethod
    {
        return PaymentMethod::create($request->validated());
    }

    public function update(UpdatePaymentMethodRequest $request, PaymentMethod $payment): PaymentMethod
    {
        $payment->update($request->validated());

        return $payment;
    }

    public function destroy(PaymentMethod $payment): ?bool
    {
        return $payment->delete();
    }
}
