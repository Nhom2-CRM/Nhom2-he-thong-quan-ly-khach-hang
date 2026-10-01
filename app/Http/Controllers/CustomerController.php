<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerRequest;
use App\Models\Customer;
use App\Services\CustomerService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    protected CustomerService $customerService;

    public function __construct(CustomerService $customerService)
    {
        $this->customerService = $customerService;
    }

    /**
     * Display a listing of the customers.
     */
    public function index(Request $request): JsonResponse
    {
        $customers = $this->customerService->getAllCustomers(
            $request->only(['search', 'status']),
            (int) $request->get('per_page', 15)
        );

        return response()->json([
            'status' => 'success',
            'data' => $customers,
        ]);
    }

    /**
     * Store a newly created customer in storage.
     */
    public function store(CustomerRequest $request): JsonResponse
    {
        $data = $request->validated();
        if ($request->user()) {
            $data['user_id'] = $request->user()->id;
        }

        $customer = $this->customerService->createCustomer($data);

        return response()->json([
            'status' => 'success',
            'message' => 'Tạo khách hàng thành công.',
            'data' => $customer,
        ], 201);
    }

    /**
     * Display the specified customer.
     */
    public function show(Customer $customer): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'data' => $customer,
        ]);
    }

    /**
     * Update the specified customer in storage.
     */
    public function update(CustomerRequest $request, Customer $customer): JsonResponse
    {
        $updatedCustomer = $this->customerService->updateCustomer($customer, $request->validated());

        return response()->json([
            'status' => 'success',
            'message' => 'Cập nhật thông tin khách hàng thành công.',
            'data' => $updatedCustomer,
        ]);
    }

    /**
     * Remove the specified customer from storage.
     */
    public function destroy(Customer $customer): JsonResponse
    {
        $this->customerService->deleteCustomer($customer);

        return response()->json([
            'status' => 'success',
            'message' => 'Xóa khách hàng thành công.',
        ]);
    }
}
