<?php

namespace App\Http\Controllers\Api\User;

use App\Exceptions\ApiErrorException;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\Address\StoreUserAddressRequest;
use App\Http\Requests\User\Address\UpdateUserAddressRequest;
use App\Http\Resources\ErrorResource;
use App\Http\Resources\SuccessResource;
use App\Http\Resources\User\UserAddressResource;
use App\Models\UserAddress;
use App\Repositories\Eloquent\UserAddressRepository;
use Illuminate\Support\Facades\Gate;

class UserAddressController extends Controller
{
    public function __construct(
        private readonly UserAddressRepository $userAddressRepository
    ) {
    }

    /** @throws ApiErrorException */
    public function index(): SuccessResource
    {
        $userAddress = $this->userAddressRepository->getAddressByUserId(authUser()->id);
        return SuccessResource::make([
            'data' => UserAddressResource::collection($userAddress)
        ]);
    }

    /** @throws ApiErrorException */
    public function store(StoreUserAddressRequest $request): SuccessResource
    {
        $data = $request->validated();
        $data['user_id'] = authUser()->id;
        $address = $this->userAddressRepository->create($data);

        return SuccessResource::make([
            'data' => $address,
            'message' => trans('messages.successfully_created'),
        ]);
    }

    /** @throws ApiErrorException */
    public function show(UserAddress $userAddress): SuccessResource|ErrorResource
    {
        $user = authUser();
        if (!Gate::forUser($user)->allows('authorize', $userAddress)) {

            return SuccessResource::make([
                'data' => UserAddressResource::make($userAddress)
            ]);
        }
        return ErrorResource::make([
            'message' => trans('messages.access_denied'),
        ]);
    }

    /** @throws ApiErrorException */
    public function update(UpdateUserAddressRequest $request, UserAddress $userAddress): SuccessResource|ErrorResource
    {
        $user = authUser();
        if (!Gate::forUser($user)->allows('authorize', $userAddress)) {
            $userAddress->update($request->validated());
            return new SuccessResource([
                'data' => UserAddressResource::make($userAddress)
            ]);
        }
        return ErrorResource::make([
            'message' =>  trans('messages.access_denied')
        ]);
    }

    /** @throws ApiErrorException */
    public function destroy(UserAddress $userAddress): SuccessResource|ErrorResource
    {
        $user = authUser();
        if (!Gate::forUser($user)->allows('authorize', $userAddress)) {
            $userAddress->delete();
            return new SuccessResource([
                'message' => trans('messages.successfully_deleted'),
            ]);
        }
        return ErrorResource::make([
            'message' =>  trans('messages.access_denied')
        ]);
    }
}
