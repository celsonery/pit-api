<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct(protected ProductService $productService)
    {
    }

    public function index(Request $request): JsonResponse
    {
        if ($request->search) {
            logs()->debug('Realizando busca: ', $request->search);
        }

        $products = $this->productService->list();

        return response()->json($products);
    }

   public function store(StoreProductRequest $request): Product
   {
        return $this->productService->store($request);
    }

    public function show(int $id): JsonResponse
    {
        $product = $this->productService->show($id);

        return response()->json($product);
    }

    public function update(UpdateProductRequest $request, Product $product): JsonResponse
    {
        $product = $this->productService->update($request, $product);

        return response()->json($product);
    }

    public function destroy(Product $product): JsonResponse
    {
        $this->productService->destroy($product);

        return response()->json(['message' => 'Product deleted!']);
    }
}
