<?php

namespace App\Services;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductService
{
    public function list(Request $request)
    {
        if ($request->has('search')) {
            logs()->debug($request->search);

            return Product::query()
                ->with(['gtins' => fn ($gtins) => $gtins->select('id', 'gtin', 'price', 'quantity', 'product_id')
                    ->where('quantity', '>', 0)
                    ->with(['images' => fn ($images) => $images->select('id', 'cover', 'url', 'gtin_id')
                        ->where('cover', 1)
                        ->limit(1),
                    ]),
                ])
                ->where('name', 'like', "%{$request->search}%")
                ->select(['id', 'name', 'slug'])
                ->paginate();
        }

        return Product::query()
            ->with(['gtins' => fn ($gtins) => $gtins->select('id', 'gtin', 'price', 'quantity', 'product_id')
                ->where('quantity', '>', 0)
                ->with(['images' => fn ($images) => $images->select('id', 'cover', 'url', 'gtin_id')
                    ->where('cover', 1)
                    ->limit(1),
                ]),
            ])
            ->select(['id', 'name', 'slug'])
            ->paginate();
    }

    public function store(StoreProductRequest $request): Product
    {
        return Product::create($request->validated());
    }

    public function show(int $id)
    {
        return Product::with(['gtins' => fn ($gtins) => $gtins->limit(1)
            ->with(['images']),
        ])
            ->where('id', $id)
            ->get();
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
