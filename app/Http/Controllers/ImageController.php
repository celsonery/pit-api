<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreImageRequest;
use App\Http\Requests\UpdateImageRequest;
use App\Models\Image;
use App\Services\ImageService;
use Illuminate\Http\JsonResponse;

class ImageController extends Controller
{
    public function __construct(protected ImageService $imageService)
    {
    }

    public function index(): JsonResponse
    {
        $images = $this->imageService->list();

        return response()->json($images);
    }

    public function store(StoreImageRequest $request): JsonResponse
    {
        $imagem = $this->imageService->store($request);

        return response()->json($imagem);
    }

    public function show(Image $image): JsonResponse
    {
        return response()->json($image);
    }
    public function update(UpdateImageRequest $request, Image $image): JsonResponse
    {
        $image = $this->imageService->update($request, $image);

        return response()->json($image);
    }

    public function destroy(Image $image): JsonResponse
    {
        $this->imageService->destroy($image);

        return response()->json(['messge' => 'Image deleted!']);
    }
}
