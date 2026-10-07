<?php

namespace App\Services;

use App\Repositories\Contracts\CustomerRepositoryInterface;
use App\Enums\DataScopeEnum;
use App\Models\User;

class CustomerService
{
    public function __construct(
        protected CustomerRepositoryInterface $customerRepository
    ) {}

    public function listCustomers(User $user, DataScopeEnum $scope)
    {
        return $this->customerRepository->getPaginated($user, $scope);
    }

    public function createCustomer(array $data, User $user)
    {
        $data['user_id'] = $user->id;
        $data['sales_team_id'] = $user->sales_team_id;

        return $this->customerRepository->create($data);
    }
}