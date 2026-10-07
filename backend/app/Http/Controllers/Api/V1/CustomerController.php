<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use App\Http\Resources\CustomerResource;
use App\Models\Customer;
use App\Services\CustomerService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function __construct(
        private CustomerService $customerService
    ) {
    }

    public function index(Request $request): JsonResponse
    {
        $customers = $this->customerService->getCustomers(
            (int) $request->query('page', 1),
            (int) $request->query('perPage', 10)
        );

        return response()->json([
            'success' => true,
            'data' => CustomerResource::collection($customers),
            'message' => 'Lấy danh sách khách hàng thành công.',
        ]);
    }

    public function store(CreateCustomerRequest $request): JsonResponse
    {
        $customer = $this->customerService->createCustomer(
            $request->validated(),
            (int) $request->user()->id
        );

        return response()->json([
            'success' => true,
            'data' => new CustomerResource($customer),
            'message' => 'Tạo khách hàng thành công.',
        ], 201);
    }

    public function show(Customer $customer): JsonResponse
    {
        $this->authorize('view', $customer);

        return response()->json([
            'success' => true,
            'data' => new CustomerResource($customer),
            'message' => 'Lấy thông tin khách hàng thành công.',
        ]);
    }

    public function update(
        UpdateCustomerRequest $request,
        Customer $customer
    ): JsonResponse {
        $this->authorize('update', $customer);

        $customer = $this->customerService->updateCustomer(
            $customer,
            $request->validated()
        );

        return response()->json([
            'success' => true,
            'data' => new CustomerResource($customer),
            'message' => 'Cập nhật khách hàng thành công.',
        ]);
    }

    public function destroy(Customer $customer): JsonResponse
    {
        $this->authorize('delete', $customer);

        $this->customerService->deleteCustomer($customer);

        return response()->json([
            'success' => true,
            'data' => null,
            'message' => 'Xóa khách hàng thành công.',
        ]);
    }
}