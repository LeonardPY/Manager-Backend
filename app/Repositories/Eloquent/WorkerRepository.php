<?php

namespace App\Repositories\Eloquent;

use App\Http\Filters\Worker\WorkerFilter;
use App\Models\Worker;
use App\Repositories\WorkerRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

final class WorkerRepository extends BaseRepository implements WorkerRepositoryInterface
{
    public function __construct(Worker $model)
    {
        parent::__construct($model);
    }

    public function getWorkersByOrganizationId(int $organizationId, WorkerFilter $filter): LengthAwarePaginator
    {
        return $this->model->where('organization_id', $organizationId)
            ->filter($filter)
            ->paginate($filter->LIMIT, '*', 'page', $filter->PAGE);
    }
}
