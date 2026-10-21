<?php

namespace App\Repositories\Eloquent;

use App\Models\Customer;
use App\Repositories\Contracts\CustomerRepositoryInterface;

class CustomerRepository implements CustomerRepositoryInterface
{
    public function getAllPaginated(int $perPage = 15)
    {
        return Customer::paginate($perPage);
    }

    public function findById(int $id)
    {
        return Customer::findOrFail($id);
    }
}