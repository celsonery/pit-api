<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    public function __construct(protected ProductService $productService)
    {
    }

    public function index(): JsonResponse
    {
        $products = $this->productService->list();

        return response()->json($products);
    }

   public function store(StoreProductRequest $request)
    {
        return $this->productService->store($request);
    }

    public function show(Product $product)
    {
        return response()->json($product);
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        $product = $this->productService->update($request, $product);

        return response()->json($product);
    }

    public function destroy(Product $product)
    {
        $this->productService->destroy($product);

        return response()->json(['message' => 'Product deleted!']);
    }
}
