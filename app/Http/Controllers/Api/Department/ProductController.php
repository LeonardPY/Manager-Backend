<?php

namespace App\Http\Controllers\Api\Department;

use App\Enums\ProductStatusEnum;
use App\Exceptions\ApiErrorException;
use App\Http\Controllers\Controller;
use App\Http\Filters\ProductFilter;
use App\Http\Requests\Product\DestroyProductRequest;
use App\Http\Requests\Product\ProductFilterRequest;
use App\Http\Requests\Product\ShowProductRequest;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Http\Resources\PaginationResource;
use App\Http\Resources\Product\OneProductResource;
use App\Http\Resources\Product\ProductResource;
use App\Http\Resources\SuccessResource;
use App\Models\Product;
use App\Repositories\ProductRepositoryInterface;
use App\Services\ProductService;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\Arr;

class ProductController extends Controller
{
    public function __construct(
        private readonly ProductRepositoryInterface $productRepository,
        private readonly ProductService $productService
    ) {
    }

    /** @throws BindingResolutionException|ApiErrorException */
    public function index(ProductFilterRequest $request): PaginationResource
    {
        $filter = app()->make(ProductFilter::class, ['queryParams' => $request->validated()]);
        $products = $this->productRepository->allProduct($filter, authUser()->id);

        return PaginationResource::make([
            'data' => ProductResource::collection($products),
            'pagination' => $products
        ]);

    }

    /** @throws ApiErrorException */
    public function store(StoreProductRequest $request): SuccessResource
    {
        $data = $request->validated();
        $data = $this->productService->setProductCode($data);
        $data['slug'] = $this->productService->generateSlug($data['name']);
        $data['user_id'] = authUser()->id;
        $product = $this->productRepository->create($data);
        $this->productService->mainUploadPicture($data, $product);
        return SuccessResource::make([
            'message' => trans('message.successfully_created'),
        ]);
    }

    public function show(ShowProductRequest $request, Product $product): SuccessResource
    {
        $request->validated();
        $product = $this->productRepository->findProductById($product->id);
        return SuccessResource::make([
            'data' => OneProductResource::make($product),
        ]);
    }

    public function update(UpdateProductRequest $request, Product $product): SuccessResource
    {
        $data = $request->validated();
        $product = $this->productRepository->findProductById($product->id);
        $this->productService->mainUploadPicture($data, $product);
        $this->productRepository->update($product->id, $data);
        return SuccessResource::make([
            'message' => trans('message.successfully_updated'),
        ]);
    }

    public function destroy(DestroyProductRequest $request, Product $product): SuccessResource
    {
        $request->validated();
        $product = $this->productRepository->findProductById($product->id);
        $this->productRepository->update($product->id, [
            'status' => ProductStatusEnum::DELETED->value
        ]);
        return SuccessResource::make([
            'message' => trans('message.successfully_deleted'),
        ]);
    }
}
