<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    use AuthorizesRequests;

    public function __construct(
        private readonly ProductService $productService
    ) {
    }

    public function index(Request $request): JsonResponse
    {
        $this->authorize('viewAny', Product::class);

        $page = (int) $request->input('page', 1);
        $perPage = (int) $request->input('per_page', 10);

        $products = $this->productService->getProducts($page, $perPage);

        return response()->json([
            'success' => true,
            'data' => ProductResource::collection($products),
            'message' => 'Lấy danh sách sản phẩm thành công.',
        ]);
    }

    public function store(CreateProductRequest $request): JsonResponse
    {
        $this->authorize('create', Product::class);

        $product = $this->productService->createProduct($request->validated());

        return response()->json([
            'success' => true,
            'data' => new ProductResource($product),
            'message' => 'Tạo sản phẩm thành công.',
        ], 201);
    }

    public function show(int $id): JsonResponse
    {
        $product = $this->productService->getProduct($id);

        $this->authorize('view', $product);

        return response()->json([
            'success' => true,
            'data' => new ProductResource($product),
            'message' => 'Lấy thông tin sản phẩm thành công.',
        ]);
    }

    public function update(UpdateProductRequest $request, int $id): JsonResponse
    {
        $product = $this->productService->getProduct($id);

        $this->authorize('update', $product);

        $product = $this->productService->updateProduct(
            $product,
            $request->validated()
        );

        return response()->json([
            'success' => true,
            'data' => new ProductResource($product),
            'message' => 'Cập nhật sản phẩm thành công.',
        ]);
    }

    public function destroy(int $id): JsonResponse
    {
        $product = $this->productService->getProduct($id);

        $this->authorize('delete', $product);

        $this->productService->deleteProduct($product);

        return response()->json([
            'success' => true,
            'data' => null,
            'message' => 'Xóa sản phẩm thành công.',
        ]);
    }
}