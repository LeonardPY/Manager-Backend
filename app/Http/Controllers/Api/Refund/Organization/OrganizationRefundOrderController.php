<?php

namespace App\Http\Controllers\Api\Refund\Organization;

use App\Exceptions\ApiErrorException;
use App\Http\Controllers\Controller;
use App\Http\Filters\Refund\RefundOrderFilter;
use App\Http\Requests\RefundOrder\RefundOrderFilterRequest;
use App\Http\Resources\Refund\OrderRefundResource;
use App\Http\Resources\SuccessResource;
use App\Repositories\RefundOrderRepositoryInterface;
use Illuminate\Contracts\Container\BindingResolutionException;

class OrganizationRefundOrderController extends Controller
{
    public function __construct(
        private readonly RefundOrderRepositoryInterface $refundOrderRepository,
    ) {
    }

    /** @throws ApiErrorException|BindingResolutionException */
    public function index(RefundOrderFilterRequest $request): SuccessResource
    {
        $user = authUser();
        $filter = app()->make(RefundOrderFilter::class, [
            'queryParams' => array_filter($request->validated())
        ]);
        $refundOrders = $this->refundOrderRepository->filterRefundOrderByFactoryId(
            $user->id,
            $filter
        );
        return new SuccessResource([
            'data' => OrderRefundResource::collection($refundOrders),
        ]);
    }
}
