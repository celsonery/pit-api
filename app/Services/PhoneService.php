<?php

namespace App\Services;

use App\Http\Requests\StorePhoneRequest;
use App\Http\Requests\UpdatePhoneRequest;
use App\Models\Phone;

class PhoneService
{
    public function list()
    {
        return Phone::select(['id', 'number', 'type'])
            ->paginate();
    }

    public function store(StorePhoneRequest $request): Phone
    {
        return Phone::create($request->validated());
    }

    public function update(UpdatePhoneRequest $request, Phone $phone): Phone
    {
        $phone->update($request->validated());

        return $phone;
    }

    public function destroy(Phone $phone): ?bool
    {
        return $phone->delete();
    }
}
