<?php

namespace App\Services;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;

class ProductService
{
    public function list()
    {
        return Product::select(['id', 'name', 'slug', 'feature'])
            ->paginate();
    }

    public function store(StoreProductRequest $request): Product
    {
        return Product::create($request->validated());
    }

    public function update(UpdateProductRequest $request, Product $product): Product
    {
        $product->update($request->validated());

        return $product;
    }

    public function destroy(Product $product): ?bool
    {
        return $product->delete();
    }
}
