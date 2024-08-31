<?php

namespace App\Services;

use App\Http\Requests\StoreImageRequest;
use App\Http\Requests\UpdateImageRequest;
use App\Models\Image;

class ImageService
{
    public function list()
    {
        return Image::select(['id', 'gtin_id', 'url', 'cover'])
            ->paginate();
    }

    public function store(StoreImageRequest $request): Image
    {
        return Image::create($request->validated());
    }

    public function update(UpdateImageRequest $request, Image $image): Image
    {
        $image->update($request->validated());

        return $image;
    }

    public function destroy(Image $image): ?bool
    {
        return $image->delete();
    }
}
