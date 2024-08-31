<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStoreRequest;
use App\Http\Requests\UpdateStoreRequest;
use App\Models\Store;
use App\Services\StoreService;
use Illuminate\Http\JsonResponse;

class StoreController extends Controller
{
    public function __construct(protected StoreService $storeService)
    {
    }

    public function index(): JsonResponse
    {
        $stores = $this->storeService->list();

        return response()->json($stores);
    }

   public function store(StoreStoreRequest $request): JsonResponse
   {
        $store = $this->storeService->store($request);

        return response()->json($store);
    }

    public function show(Store $store): JsonResponse
    {
        return response()->json($store);
    }

    public function update(UpdateStoreRequest $request, Store $store): JsonResponse
    {
        $store = $this->storeService->update($request, $store);

        return response()->json($store);
    }

    public function destroy(Store $store): JsonResponse
    {
        $this->storeService->destroy($store);

        return response()->json(['message' => 'Store deleted!']);
    }
}
