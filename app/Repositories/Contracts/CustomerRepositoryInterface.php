<?php

namespace App\Repositories\Contracts;

interface CustomerRepositoryInterface
{
    public function getAllPaginated(int $perPage = 15);
    public function findById(int $id);
}