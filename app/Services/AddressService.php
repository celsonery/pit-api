<?php

namespace App\Services;

use App\Http\Requests\StoreAddressRequest;
use App\Http\Requests\UpdateAddressRequest;
use App\Models\Address;

class AddressService
{
    public function list()
    {
        return Address::paginate();
    }

    public function store(StoreAddressRequest $request): Address
    {
        return Address::create($request->validated());
    }

    public function update(UpdateAddressRequest $request, Address $address): Address
    {
        $address->update($request->validated());

        return $address;
    }

    public function destroy(Address $address): bool
    {
        return $address->delete();
    }
}
