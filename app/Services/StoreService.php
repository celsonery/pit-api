<?php

namespace App\Services;

use App\Http\Requests\StoreStoreRequest;
use App\Http\Requests\UpdateStoreRequest;
use App\Models\Store;

class StoreService
{
    public function list()
    {
        return Store::select(['id', 'name', 'cnpj'])
            ->paginate();
    }

    public function store(StoreStoreRequest $request): Store
    {
        return Store::create($request->validated());
    }

    public function update(UpdateStoreRequest $request, Store $store): Store
    {
        $store->update($request->validated());

        return $store;
    }

    public function destroy(Store $store): ?bool
    {
        return $store->delete();
    }
}
