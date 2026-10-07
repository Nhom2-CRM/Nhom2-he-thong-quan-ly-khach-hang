<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Services\CustomerService;
use App\Http\Requests\Customer\CreateCustomerRequest;
use App\Http\Resources\CustomerResource;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function __construct(
        protected CustomerService $customerService
    ) {}

    public function index(Request $request)
    {
        $scope = $request->attributes->get('data_scope');
        $customers = $this->customerService->listCustomers($request->user(), $scope);

        return CustomerResource::collection($customers);
    }

    public function store(CreateCustomerRequest $request)
    {
        $customer = $this->customerService->createCustomer($request->validated(), $request->user());

        return (new CustomerResource($customer))->response()->setStatusCode(201);
    }
}