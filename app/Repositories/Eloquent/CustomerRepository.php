<?php

namespace App\Repositories\Eloquent;

use App\Models\Customer;
use App\Repositories\Contracts\CustomerRepositoryInterface;
<<<<<<< HEAD

class CustomerRepository implements CustomerRepositoryInterface
{
    public function getAllPaginated(int $perPage = 15)
    {
        return Customer::paginate($perPage);
    }

    public function findById(int $id)
    {
        return Customer::findOrFail($id);
=======
use Illuminate\Database\Eloquent\Collection;

class CustomerRepository implements CustomerRepositoryInterface
{
    public function getAll(): Collection
    {
        return Customer::all();
    }

    public function findById(int $id): ?Customer
    {
        return Customer::find($id);
    }

    public function create(array $data): Customer
    {
        return Customer::create($data);
    }

    public function update(int $id, array $data): bool
    {
        $customer = $this->findById($id);
        return $customer ? $customer->update($data) : false;
    }

    public function delete(int $id): bool
    {
        $customer = $this->findById($id);
        return $customer ? $customer->delete() : false;
>>>>>>> 72f5237d663e404ee450fd532a2b229ee05201ee
    }
}