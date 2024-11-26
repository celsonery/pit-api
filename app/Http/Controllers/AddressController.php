<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAddressRequest;
use App\Http\Requests\UpdateAddressRequest;
use App\Models\Address;
use App\Services\AddressService;
use Illuminate\Http\JsonResponse;

class AddressController extends Controller
{
    public function __construct(protected AddressService $addressService) {}

    public function index(): JsonResponse
    {
        $addresses = $this->addressService->list();

        return response()->json($addresses);
    }

    public function store(StoreAddressRequest $request): JsonResponse
    {
        $address = $this->addressService->store($request);

        return response()->json($address);
    }

    public function show(Address $address): JsonResponse
    {
        return response()->json($address);
    }

    public function update(UpdateAddressRequest $request, Address $address): JsonResponse
    {
        $address = $this->addressService->update($request, $address);

        return response()->json($address);
    }

    public function destroy(Address $address): JsonResponse
    {
        $this->addressService->destroy($address);

        return response()->json(['message' => 'Address deleted!']);
    }
}
