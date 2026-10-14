<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Services\CustomerService;
use App\Http\Resources\CustomerResource;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests; // Đảm bảo đã import Trait

class CustomerController extends Controller
{
    use AuthorizesRequests; // Đảm bảo đã use Trait

    public function __construct(
        protected CustomerService $customerService
    ) {}

    public function checkDuplicates(Request $request): JsonResponse
    {
        $duplicates = $this->customerService->findDuplicates(
            $request->query('tax_code'),
            $request->query('name'),
            $request->query('website')
        );

        return response()->json(['data' => $duplicates]);
    }

    public function show360(Customer $customer): JsonResponse
    {
        $customer360 = $this->customerService->getCustomer360Data($customer);

        return response()->json([
            'data' => new CustomerResource($customer360),
            'summary' => [
                'total_signed_value' => (float) ($customer360->total_signed_value ?? 0),
                'open_opportunity_value' => (float) ($customer360->open_opportunity_value ?? 0),
            ]
        ]);
    }

    public function merge(Request $request): JsonResponse
    {
        // Mở lại kiểm tra quyền ở đây:
        $this->authorize('merge', Customer::class); //

        $request->validate([
            'master_id' => 'required|exists:customers,id',
            'duplicate_id' => 'required|exists:customers,id|different:master_id',
        ]);

        $this->customerService->mergeCustomers(
            $request->integer('master_id'),
            $request->integer('duplicate_id')
        );

        return response()->json(['message' => 'Gộp khách hàng thành công.']);
    }
}