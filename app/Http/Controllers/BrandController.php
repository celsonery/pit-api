<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBrandRequest;
use App\Http\Requests\UpdateBrandRequest;
use App\Models\Brand;
use App\Services\BrandService;
use Illuminate\Http\JsonResponse;

class BrandController extends Controller
{
    public function __construct(protected BrandService $brandService) {}

    public function index(): JsonResponse
    {
        $brands = $this->brandService->list();

        return response()->json($brands);
    }

    public function store(StoreBrandRequest $request)
    {
        return $this->brandService->store($request);
    }

    public function show(Brand $brand): JsonResponse
    {
        return response()->json($brand);
    }

    public function update(UpdateBrandRequest $request, Brand $brand): JsonResponse
    {
        $brand = $this->brandService->update($request, $brand);

        return response()->json($brand);
    }

    public function destroy(Brand $brand)
    {
        $this->brandService->destroy($brand);

        return response()->json(['message' => 'Brand deleted!']);
    }
}
