<?php

namespace App\Services;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;

class ProductService
{
    public function list()
    {
        return Product::query()
            ->with(['gtins' => fn ($gtins) => $gtins->select('id', 'gtin', 'price', 'quantity', 'product_id')
                ->where('quantity', '>', 0)
                ->with(['images' => fn ($images) =>
                $images->select('id', 'cover', 'url', 'gtin_id')
                    ->where('cover', 1)
                    ->limit(1)
            ])
        ])
            ->select(['id', 'name'])
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
