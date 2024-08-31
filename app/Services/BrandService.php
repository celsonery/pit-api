<?php

namespace App\Services;

use App\Http\Requests\StoreBrandRequest;
use App\Http\Requests\UpdateBrandRequest;
use App\Models\Brand;

class BrandService
{
    public function list()
    {
        return Brand::select(['id', 'name'])
            ->paginate();
    }

    public function store(StoreBrandRequest $request): Brand
    {
        return Brand::create($request->validated());
    }

    public function update(UpdateBrandRequest $request, Brand $brand): Brand
    {
        $brand->update($request->validated());

        return $brand;
    }

    public function destroy(Brand $brand): bool
    {
        return $brand->delete();
    }
}
