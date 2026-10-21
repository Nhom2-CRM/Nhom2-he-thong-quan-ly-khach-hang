<?php

<<<<<<< HEAD
namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
=======
namespace App\Services;

use App\Repositories\Contracts\CustomerRepositoryInterface;

class CustomerService
{
    public function __construct(
        protected CustomerRepositoryInterface $customerRepository
    ) {}

    public function getCustomerList()
    {
        return $this->customerRepository->getAll();
    }

    public function findCustomer(int $id)
    {
        return $this->customerRepository->findById($id);
    }

    public function storeCustomer(array $data)
    {
        return $this->customerRepository->create($data);
    }

    public function updateCustomer(int $id, array $data)
    {
        return $this->customerRepository->update($id, $data);
    }

    public function deleteCustomer(int $id)
    {
        return $this->customerRepository->delete($id);
    }
}
>>>>>>> 72f5237d663e404ee450fd532a2b229ee05201ee
