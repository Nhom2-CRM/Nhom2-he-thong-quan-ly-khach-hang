<?php

namespace App\Repositories\Eloquent;

use App\Models\Customer;
use App\Models\User;
use App\Enums\DataScopeEnum;
use App\Services\DataScopeService;
use App\Repositories\Contracts\CustomerRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class CustomerRepository implements CustomerRepositoryInterface
{
    public function __construct(
        protected Customer $model,
        protected DataScopeService $dataScopeService
    ) {}

    public function getPaginated(User $user, DataScopeEnum $scope, int $perPage = 15): LengthAwarePaginator
    {
        $query = $this->model->newQuery();
        $this->dataScopeService->applyScope($query, $user, $scope);

        return $query->latest()->paginate($perPage);
    }

    public function create(array $data): mixed
    {
        return $this->model->create($data);
    }
}