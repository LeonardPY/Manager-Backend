<?php

namespace App\Http\Controllers\Api\Organization;

use App\Exceptions\ApiErrorException;
use App\Http\Controllers\Controller;
use App\Http\Filters\Worker\WorkerFilter;
use App\Http\Requests\Worker\StoreWorkerRequest;
use App\Http\Requests\Worker\WorkerFilterRequest;
use App\Http\Resources\PaginationResource;
use App\Http\Resources\SuccessResource;
use App\Http\Resources\Worker\WorkerResource;
use App\Repositories\WorkerRepositoryInterface;
use App\Services\Worker\WorkerService;
use Illuminate\Contracts\Container\BindingResolutionException;
use Throwable;

class WorkerController extends Controller
{
    public function __construct(
        private readonly WorkerRepositoryInterface $workerRepository,
        private readonly WorkerService $workerService
    ) {
    }

    /** @throws ApiErrorException|BindingResolutionException */
    public function index(WorkerFilterRequest $request): PaginationResource
    {
        $data = $request->validated();
        $filter = app()->make(WorkerFilter::class, ['queryParams' => array_filter($data)]);
        $workers = $this->workerRepository->getWorkersByOrganizationId(authUser()->id, $filter);
        return PaginationResource::make([
            'data' => WorkerResource::collection($workers),
            'pagination' => $workers
        ]);
    }

    /** @throws ApiErrorException|Throwable */
    public function store(StoreWorkerRequest $request): SuccessResource
    {
        $data = $request->validated();

        $worker = $this->workerService->makeWorker(authUser(), $data);

        return SuccessResource::make([
            'data' => WorkerResource::make($worker)
        ]);
    }
}
