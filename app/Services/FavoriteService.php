<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteService
{
    public function list()
    {
        return Auth::user()->products()
            ->with(['gtins' => fn ($gtins) => $gtins->select('id', 'gtin', 'price', 'quantity', 'product_id')
                ->where('quantity', '>', 0)
                ->with(['images' => fn ($images) =>
                $images->select('id', 'cover', 'url', 'gtin_id')
                    ->where('cover', 1)
                    ->limit(1)
                ])
            ])
            ->select(['product_id', 'name'])
            ->paginate();
    }

    public function store(Request $request)
    {
        return Auth::user()->products()
            ->attach([$request->id]);
    }

    public function destroy(Product $favorite)
    {
        return Auth::user()->products()
            ->detach([$favorite->id]);
    }
}
