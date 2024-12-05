<?php

namespace App\Http\Controllers\Api\Department;

use App\Exceptions\ApiErrorException;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductDescription\StoreProductDescriptionRequest;
use App\Http\Requests\ProductDescription\UpdateProductDescriptionRequest;
use App\Http\Requests\ProductPicture\StoreProductPictureRequest;
use App\Http\Resources\ErrorResource;
use App\Http\Resources\SuccessResource;
use App\Models\Product;
use App\Models\User;
use App\Repositories\Eloquent\ProductDescriptionRepository;
use App\Repositories\Eloquent\ProductPictureRepository;
use App\Services\ProductService;
use Symfony\Component\HttpFoundation\Response;

class ProductDescriptionController extends Controller
{
    public function __construct(
        private readonly ProductDescriptionRepository $descriptionRepository,
        private readonly ProductPictureRepository     $productPictureRepository,
        private readonly ProductService               $productService
    )
    {
    }


    /** @throws ApiErrorException */
    public function store(
        StoreProductDescriptionRequest $productDescriptionRequest,
        StoreProductPictureRequest     $productPictureRequest,
        Product                        $product
    ): SuccessResource|Response
    {
        /** @var Product $product **/
        /** @var User $user **/
        $productDescriptionValidated = $productDescriptionRequest->validated();
        $productPictureValidated = $productPictureRequest->validated();

        $user = authUser();
        if ($product->haveAccess($user->id) || $user->isAdmin()) {
            $productPictureValidatedData = $this->productService->uploadPictures($productPictureValidated, $product->id);
            $this->descriptionRepository->updateOrCreate(['product_id' => $product->id], $productDescriptionValidated);
            $this->productPictureRepository->insert($productPictureValidatedData);
            return SuccessResource::make([
                'message' => trans('messages.successfully_created'),
            ]);
        }
        return (new ErrorResource([
            'message' => 'Forbidden'
        ]))->response()->setStatusCode(403);
    }


    /** @throws ApiErrorException */
    public function update(UpdateProductDescriptionRequest $productDescriptionRequest, Product $product): SuccessResource|ErrorResource
    {
        /** @var Product $product **/
        /** @var User $user **/
        $productDescriptionValidated = $productDescriptionRequest->validated();
        $user = authUser();

        if ($product->haveAccess($user->id) || $user->isAdmin()) {
            $this->descriptionRepository->updateOrCreate(['product_id' => $product->id], $productDescriptionValidated);
            return SuccessResource::make([
                'message' => trans('messages.successfully_updated'),
            ]);
        }
        return ErrorResource::make([
            'message' => trans('messages.failed')
        ])->setStatusCode(403);
    }

}
