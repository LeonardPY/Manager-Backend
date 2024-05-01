<?php

namespace App\Http\Controllers\Api\User;

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
    )
    {
    }

    public function index(): SuccessResource
    {
        $userAddress = $this->userAddressRepository->getAddressByUserId(auth()->id());
        return SuccessResource::make([
            'data' => UserAddressResource::collection($userAddress)
        ]);
    }

    public function store(StoreUserAddressRequest $request): SuccessResource
    {
        $data = $request->validated();

        $address = $this->userAddressRepository->create($data + ['user_id' => auth()->id()]);

        return SuccessResource::make([
            'data' => $address,
            'message' => 'successfully_created',
        ]);
    }

    public function show(UserAddress $userAddress): SuccessResource|ErrorResource
    {
        if (Gate::forUser(auth()->user())->allows('authorize', $userAddress)) {

            return SuccessResource::make([
                'data' => UserAddressResource::make($userAddress)
            ]);
        }
        return ErrorResource::make([
            'message' => 'Access Denied'
        ]);
    }

    public function update(UpdateUserAddressRequest $request, UserAddress $userAddress): SuccessResource|ErrorResource
    {
        if (Gate::forUser(auth()->user())->allows('authorize', $userAddress)) {

            $userAddress->update($request->validated());

            return new SuccessResource([
                'data' => UserAddressResource::make($userAddress)
            ]);
        }
        return ErrorResource::make([
            'message' => 'Access Denied'
        ]);
    }

    public function destroy(UserAddress $userAddress): SuccessResource|ErrorResource
    {
        if (Gate::forUser(auth()->user())->allows('authorize', $userAddress)) {

            $userAddress->delete();

            return new SuccessResource([
                'message' => 'successfully_deleted',
            ]);
        }
        return ErrorResource::make([
            'message' => 'Access Denied'
        ]);
    }
}
