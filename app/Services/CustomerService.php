<?php

namespace App\Services;

use App\Models\Customer;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class CustomerService
{
    /**
     * Get paginated or listed customers with filtering.
     *
     * @param array $filters
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getAllCustomers(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        $query = Customer::query();

        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('company', 'like', "%{$search}%");
            });
        }

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        return $query->latest()->paginate($perPage);
    }

    /**
     * Create a new customer.
     *
     * @param array $data
     * @return Customer
     */
    public function createCustomer(array $data): Customer
    {
        return Customer::create($data);
    }

    /**
     * Get a customer by ID.
     *
     * @param int $id
     * @return Customer
     */
    public function getCustomerById(int $id): Customer
    {
        return Customer::findOrFail($id);
    }

    /**
     * Update an existing customer.
     *
     * @param Customer|int $customer
     * @param array $data
     * @return Customer
     */
    public function updateCustomer(Customer|int $customer, array $data): Customer
    {
        $customerModel = $customer instanceof Customer ? $customer : Customer::findOrFail($customer);
        $customerModel->update($data);
        return $customerModel;
    }

    /**
     * Delete a customer.
     *
     * @param Customer|int $customer
     * @return bool
     */
    public function deleteCustomer(Customer|int $customer): bool
    {
        $customerModel = $customer instanceof Customer ? $customer : Customer::findOrFail($customer);
        return (bool) $customerModel->delete();
    }
}
