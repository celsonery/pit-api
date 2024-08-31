<?php

namespace App\Services;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;

class CategoryService
{
    public function list()
    {
        return Category::select(['id', 'name'])
            ->paginate();
    }

    public function store(StoreCategoryRequest $request): Category
    {
        $category = Category::create($request->validated());

        return $category;
    }

    public function update(UpdateCategoryRequest $request, Category $category): Category
    {
        $category->update($request->validated());

        return $category;
    }

    public function destroy(Category $category): bool
    {
        return $category->delete();
    }
}
