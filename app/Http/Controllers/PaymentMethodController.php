<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePaymentMethodRequest;
use App\Http\Requests\UpdatePaymentMethodRequest;
use App\Models\PaymentMethod;
use App\Services\PaymentMethodService;
use Illuminate\Http\JsonResponse;

class PaymentMethodController extends Controller
{
    public function __construct(protected PaymentMethodService $paymentMethodService) {}

    public function index(): JsonResponse
    {
        $payments = $this->paymentMethodService->list();

        return response()->json($payments);
    }

    public function store(StorePaymentMethodRequest $request): PaymentMethod
    {
        $payment = $this->paymentMethodService->store($request);

        return response()->json($payment);
    }

    public function show(PaymentMethod $payment): JsonResponse
    {
        return response()->json($payment);
    }

    public function update(UpdatePaymentMethodRequest $request, PaymentMethod $payment): JsonResponse
    {
        $payment = $this->paymentMethodService->update($request, $payment);

        return response()->json($payment);
    }

    public function destroy(PaymentMethod $payment): JsonResponse
    {
        $this->paymentMethodService->destroy($payment);

        return response()->json(['message' => 'Payment deleted!']);
    }
}
