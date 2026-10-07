<?php

namespace App\Services;

use App\Models\SharedCategory;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class SharedCategoryService
{
    public function getCategories(
        ?string $type = null,
        int $page = 1,
        int $perPage = 10
    ): LengthAwarePaginator {
        return SharedCategory::query()
            ->when($type, function ($query) use ($type) {
                $query->where('type', $type);
            })
            ->orderBy('sort_order')
            ->orderBy('id')
            ->paginate($perPage, ['*'], 'page', $page);
    }

    public function getCategory(int $id): SharedCategory
    {
        return SharedCategory::findOrFail($id);
    }

    public function createCategory(array $data): SharedCategory
    {
        return SharedCategory::create([
            'type' => $data['type'],
            'code' => $data['code'],
            'name' => $data['name'],
            'sort_order' => $data['sortOrder'] ?? 0,
            'is_active' => $data['isActive'] ?? true,
        ]);
    }

    public function updateCategory(
        SharedCategory $category,
        array $data
    ): SharedCategory {
        $category->update([
            'type' => $data['type'] ?? $category->type,
            'code' => $data['code'] ?? $category->code,
            'name' => $data['name'] ?? $category->name,
            'sort_order' => $data['sortOrder'] ?? $category->sort_order,
            'is_active' => $data['isActive'] ?? $category->is_active,
        ]);

        return $category->fresh();
    }

    public function deleteCategory(SharedCategory $category): void
    {
        $category->delete();
    }
}