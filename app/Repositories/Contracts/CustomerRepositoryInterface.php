<?php

namespace App\Repositories\Contracts;

<<<<<<< HEAD
interface CustomerRepositoryInterface
{
    public function getAllPaginated(int $perPage = 15);
    public function findById(int $id);
=======
use Illuminate\Database\Eloquent\Collection;
use App\Models\Customer;

interface CustomerRepositoryInterface
{
    public function getAll(): Collection;
    public function findById(int $id): ?Customer;
    public function create(array $data): Customer;
    public function update(int $id, array $data): bool;
    public function delete(int $id): bool;
>>>>>>> 72f5237d663e404ee450fd532a2b229ee05201ee
}