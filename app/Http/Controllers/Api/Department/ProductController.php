<?php

namespace App\Http\Controllers\Api\Department;

use App\Enums\ProductStatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Filters\ProductFilter;
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
        private readonly ProductService             $productService
    )
    {
    }

    /**
     * @throws BindingResolutionException
     */
    public function index(ProductFilterRequest $request): PaginationResource
    {
        $filter = app()->make(ProductFilter::class, ['queryParams' => $request->validated()]);

        $products = $this->productRepository->allProduct($filter, auth()->id());
        return PaginationResource::make([
            'data' => ProductResource::collection($products),
            'pagination' => $products
        ]);

    }

    public function store(StoreProductRequest $request): SuccessResource
    {
        $data = $request->validated();

        $data = $this->productService->setProductCode($data);
        $data['slug'] = $this->productService->generateSlug($data['name']);
        $product = $this->productRepository->create(Arr::except($data + ['user_id' => auth()->id()], ['picture']));
        $this->productService->mainUploadPicture($data, $product);

        return SuccessResource::make([
            'message' => 'Created Successfully'
        ]);
    }

    public function show(ShowProductRequest$request, Product $product): SuccessResource
    {
        $request->validated();
        $product = $this->productRepository->findProductById($product->getAttribute('id'));

        return SuccessResource::make([
            'data' => OneProductResource::make($product),
        ]);
    }


    public function update(UpdateProductRequest $request, Product $product): SuccessResource
    {
        $data = $request->validated();

        $this->productService->mainUploadPicture($data, $product);
        $this->productRepository->update($product->getAttribute('id'), Arr::except($data, ['picture']));

        return SuccessResource::make([
            'message' => 'Updated Successfully'
        ]);
    }


    public function destroy(Product $product): SuccessResource
    {
        $product = $this->productRepository->findOrFail($product->getAttribute('id'));
        $this->productRepository->update($product->id, ['status' => ProductStatusEnum::DELETED->value]);
        return SuccessResource::make([
            'message' => 'Deleted Successfully'
        ]);
    }
}
