<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateSharedCategoryRequest;
use App\Http\Requests\UpdateSharedCategoryRequest;
use App\Http\Resources\SharedCategoryResource;
use App\Models\SharedCategory;
use App\Services\SharedCategoryService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SharedCategoryController extends Controller
{
    use AuthorizesRequests;

    public function __construct(
        private readonly SharedCategoryService $sharedCategoryService
    ) {
    }

    public function index(Request $request): JsonResponse
    {
        $this->authorize('viewAny', SharedCategory::class);

        $type = $request->input('type');
        $page = (int) $request->input('page', 1);
        $perPage = (int) $request->input('per_page', 10);

        $categories = $this->sharedCategoryService->getCategories(
            $type,
            $page,
            $perPage
        );

        return response()->json([
            'success' => true,
            'data' => SharedCategoryResource::collection($categories),
            'message' => 'Lấy danh mục dùng chung thành công.',
        ]);
    }

    public function store(CreateSharedCategoryRequest $request): JsonResponse
    {
        $this->authorize('create', SharedCategory::class);

        $category = $this->sharedCategoryService->createCategory(
            $request->validated()
        );

        return response()->json([
            'success' => true,
            'data' => new SharedCategoryResource($category),
            'message' => 'Tạo danh mục thành công.',
        ], 201);
    }

    public function show(int $id): JsonResponse
    {
        $category = $this->sharedCategoryService->getCategory($id);

        $this->authorize('view', $category);

        return response()->json([
            'success' => true,
            'data' => new SharedCategoryResource($category),
            'message' => 'Lấy thông tin danh mục thành công.',
        ]);
    }

    public function update(
        UpdateSharedCategoryRequest $request,
        int $id
    ): JsonResponse {
        $category = $this->sharedCategoryService->getCategory($id);

        $this->authorize('update', $category);

        $category = $this->sharedCategoryService->updateCategory(
            $category,
            $request->validated()
        );

        return response()->json([
            'success' => true,
            'data' => new SharedCategoryResource($category),
            'message' => 'Cập nhật danh mục thành công.',
        ]);
    }

    public function destroy(int $id): JsonResponse
    {
        $category = $this->sharedCategoryService->getCategory($id);

        $this->authorize('delete', $category);

        $this->sharedCategoryService->deleteCategory($category);

        return response()->json([
            'success' => true,
            'data' => null,
            'message' => 'Xóa danh mục thành công.',
        ]);
    }
}