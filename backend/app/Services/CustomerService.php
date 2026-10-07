<?php

namespace App\Services;

use App\Models\Customer;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class CustomerService
{
    public function getCustomers(int $page = 1, int $perPage = 10): LengthAwarePaginator
    {
        return Customer::query()
            ->orderByDesc('id')
            ->paginate($perPage, ['*'], 'page', $page);
    }

    public function getCustomer(int $id): Customer
    {
        return Customer::findOrFail($id);
    }

    public function createCustomer(array $data, int $ownerId): Customer
    {
        return Customer::create([
            'name' => $data['name'],
            'tax_code' => $data['taxCode'] ?? null,
            'owner_id' => $ownerId,
            'is_active' => $data['isActive'] ?? true,
        ]);
    }

    public function updateCustomer(Customer $customer, array $data): Customer
    {
        $customer->update([
            'name' => $data['name'] ?? $customer->name,
            'tax_code' => $data['taxCode'] ?? $customer->tax_code,
            'is_active' => $data['isActive'] ?? $customer->is_active,
        ]);

        return $customer->fresh();
    }

    public function deleteCustomer(Customer $customer): void
    {
        $customer->delete();
    }
}