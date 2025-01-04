<?php

namespace App\Repositories;
use App\Http\Filters\Worker\WorkerFilter;
use Illuminate\Pagination\LengthAwarePaginator;

interface WorkerRepositoryInterface extends BaseRepositoryInterface
{
    public function getWorkersByOrganizationId(int $organizationId, WorkerFilter $filter): LengthAwarePaginator;
}
