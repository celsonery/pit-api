<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\FavoriteService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FavoritesController extends Controller
{
    public function __construct(protected FavoriteService $favoriteService) {}

    public function index(): JsonResponse
    {
        $products = $this->favoriteService->list();

        return response()->json($products);

    }

    public function store(Request $request)
    {
        return $this->favoriteService->store($request);
    }

    public function destroy(Product $favorite): JsonResponse
    {
        $this->favoriteService->destroy($favorite);

        return response()->json(['message' => 'Favorite deleted!']);
    }
}
