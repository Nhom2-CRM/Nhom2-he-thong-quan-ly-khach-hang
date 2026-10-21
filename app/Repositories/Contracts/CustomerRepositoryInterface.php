<?php

namespace App\Repositories\Contracts;

use Illuminate\Database\Eloquent\Collection;
use App\Models\Customer;

interface CustomerRepositoryInterface
{
    public function getAll(): Collection;
    public function findById(int $id): ?Customer;
    public function create(array $data): Customer;
    public function update(int $id, array $data): bool;
    public function delete(int $id): bool;
}