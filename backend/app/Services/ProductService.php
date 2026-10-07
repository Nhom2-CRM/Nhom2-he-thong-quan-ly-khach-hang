<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

class ProductService
{
    public function getProducts(int $page = 1, int $perPage = 10): LengthAwarePaginator
    {
        return Product::query()
            ->orderBy('id', 'desc')
            ->paginate($perPage, ['*'], 'page', $page);
    }

    public function getProduct(int $id): Product
    {
        return Product::findOrFail($id);
    }

    public function createProduct(array $data): Product
    {
        $productData = [
            'code' => $data['code'],
            'name' => $data['name'],
            'type' => $data['type'],
            'unit' => $data['unit'] ?? null,
            'list_price' => $data['listPrice'],
            'floor_price' => $data['floorPrice'] ?? null,
            'description' => $data['description'] ?? null,
            'is_active' => $data['isActive'] ?? true,
        ];

        if (Auth::user()?->role === 'SALES_DIRECTOR') {
            $productData['cost_price'] = $data['costPrice'] ?? null;
        }

        return Product::create($productData);
    }

    public function updateProduct(Product $product, array $data): Product
    {
        $productData = [
            'code' => $data['code'] ?? $product->code,
            'name' => $data['name'] ?? $product->name,
            'type' => $data['type'] ?? $product->type,
            'unit' => $data['unit'] ?? $product->unit,
            'list_price' => $data['listPrice'] ?? $product->list_price,
            'floor_price' => $data['floorPrice'] ?? $product->floor_price,
            'description' => $data['description'] ?? $product->description,
            'is_active' => $data['isActive'] ?? $product->is_active,
        ];

        if (Auth::user()?->role === 'SALES_DIRECTOR') {
            $productData['cost_price'] = $data['costPrice'] ?? $product->cost_price;
        }

        $product->update($productData);

        return $product->fresh();
    }

    public function deleteProduct(Product $product): void
    {
        $product->update([
            'is_active' => false,
        ]);
    }
}