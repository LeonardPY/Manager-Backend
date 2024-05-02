<?php

namespace App\Http\Controllers\Api\Department;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductDescription\StoreProductDescriptionRequest;
use App\Http\Requests\ProductDescription\UpdateProductDescriptionRequest;
use App\Http\Requests\ProductPicture\StoreProductPictureRequest;
use App\Http\Resources\ErrorResource;
use App\Http\Resources\SuccessResource;
use App\Repositories\Eloquent\ProductDescriptionRepository;
use App\Repositories\Eloquent\ProductPictureRepository;
use App\Repositories\ProductRepositoryInterface;
use App\Services\ProductService;
use Symfony\Component\HttpFoundation\Response;

class ProductDescriptionController extends Controller
{
    public function __construct(
        private readonly ProductRepositoryInterface   $productRepository,
        private readonly ProductDescriptionRepository $descriptionRepository,
        private readonly ProductPictureRepository     $productPictureRepository,
        private readonly ProductService               $productService
    )
    {
    }


    public function store(
        StoreProductDescriptionRequest $productDescriptionRequest,
        StoreProductPictureRequest     $productPictureRequest,
        int                            $productId
    ): SuccessResource|Response
    {
        $productDescriptionValidated = $productDescriptionRequest->validated();
        $productPictureValidated     = $productPictureRequest->validated();
        $product = $this->productRepository->findOrFail($productId);
        if($product->haveAccess(auth()->id()) || auth()->user()->isAdmin()) {
            $productPictureValidatedData = $this->productService->uploadPictures($productPictureValidated, $productId);
            $this->descriptionRepository->updateOrCreate(['product_id' => $product->id], $productDescriptionValidated);
            $this->productPictureRepository->insert($productPictureValidatedData);
            return SuccessResource::make([
                'message' => 'success!'
            ]);
        };
        return (new ErrorResource([
            'message' => 'Forbidden'
        ]))->response()->setStatusCode(403);
    }

    public function update(UpdateProductDescriptionRequest $productDescriptionRequest, int $productId): SuccessResource|Response
    {
        $productDescriptionValidated = $productDescriptionRequest->validated();
        $product = $this->productRepository->findOrFail($productId);
        if($product->haveAccess(auth()->id()) || auth()->user()->isAdmin()) {
            $this->descriptionRepository->updateOrCreate(['product_id' => $product->id], $productDescriptionValidated);
            return SuccessResource::make([
                'message' => 'success!'
            ]);
        };
        return (new ErrorResource([
            'message' => 'Forbidden'
        ]))->response()->setStatusCode(403);
    }

}
