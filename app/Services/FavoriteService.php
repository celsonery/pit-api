<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteService
{
    public function list()
    {
        return auth()->user()->products()
            ->with(['gtins' => fn ($gtins) => $gtins
                ->where('quantity', '>', 0)
                ->with(['images' => fn ($img) => $img
                    ->where('cover', 1)
                    ->limit(1)])])
            ->get();
    }

    public function store(Request $request)
    {
        return auth()->user()->products()
            ->attach([$request->id]);
    }

    public function destroy(Product $favorite)
    {
        return auth()->user()->products()
            ->detach([$favorite->id]);
    }
}
