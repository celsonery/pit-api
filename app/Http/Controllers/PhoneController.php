<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePhoneRequest;
use App\Http\Requests\UpdatePhoneRequest;
use App\Models\Phone;
use App\Services\PhoneService;
use Illuminate\Http\JsonResponse;

class PhoneController extends Controller
{
    public function __construct(protected PhoneService $phoneService) {}

    public function index(): JsonResponse
    {
        $phones = $this->phoneService->list();

        return response()->json($phones);
    }

    public function store(StorePhoneRequest $request): JsonResponse
    {
        $phone = $this->phoneService->store($request);

        return response()->json($phone);
    }

    public function show(Phone $phone): JsonResponse
    {
        return response()->json($phone);
    }

    public function update(UpdatePhoneRequest $request, Phone $phone): JsonResponse
    {
        $phone = $this->phoneService->update($request, $phone);

        return response()->json($phone);
    }

    public function destroy(Phone $phone): JsonResponse
    {
        $this->phoneService->destroy($phone);

        return response()->json(['message' => 'Phone deleted!']);
    }
}
