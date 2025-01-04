<?php

namespace App\Http\Controllers\Api\Organization;

use App\Exceptions\ApiErrorException;
use App\Http\Controllers\Controller;
use App\Http\Filters\CategoryFilter;
use App\Http\Requests\Category\CategoryFilterRequest;
use App\Http\Requests\Category\DestroyCategoryRequest;
use App\Http\Requests\Category\ShowCategoryRequest;
use App\Http\Requests\Category\StoreCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Http\Resources\Category\CategoryResource;
use App\Http\Resources\PaginationResource;
use App\Http\Resources\SuccessResource;
use App\Models\Category;
use App\Repositories\CategoryRepositoryInterface;
use App\Services\CategoryService;
use Illuminate\Contracts\Container\BindingResolutionException;

class CategoryController extends Controller
{
    public function __construct(
        private readonly CategoryRepositoryInterface $categoryRepository,
        private readonly CategoryService             $service
    ) {
    }

    /** @throws BindingResolutionException|ApiErrorException */
    public function index(CategoryFilterRequest $request): PaginationResource
    {
        $filter = app()->make(CategoryFilter::class, ['queryParams' => $request->validated()]);
        $categories = $this->categoryRepository->allCategories($filter,  authUser()->id);
        return PaginationResource::make([
            'data' => CategoryResource::collection($categories),
            'pagination' => $categories
        ]);
    }

    /** @throws ApiErrorException */
    public function store(StoreCategoryRequest $request): SuccessResource
    {
        $validated = $request->validated();
        $data = $this->service->uploadStoreCategoryPictures($validated);
        $data['slug'] = $this->service->generateSlug($data['name']);
        $this->categoryRepository->create($data + ['user_id' => authUser()->id]);
        return SuccessResource::make([
            'message' => trans('message.successfully_created'),
        ]);
    }

    public function show(ShowCategoryRequest $request, Category $category): SuccessResource
    {
        $request->validated();
        return SuccessResource::make([
            'data' => CategoryResource::make($category),
        ]);
    }

    public function update(UpdateCategoryRequest $request, Category $category): SuccessResource
    {
        $validated = $request->validated();
        $data = $this->service->uploadUpdateCategoryPictures($validated, $category);
        $this->categoryRepository->update($category->id, $data);
        return SuccessResource::make([
            'message' => trans('message.successfully_updated'),
            'data' => CategoryResource::make($category)
        ]);
    }

    public function destroy(DestroyCategoryRequest $request, Category $category): SuccessResource
    {
        $request->validated();
        $this->service->destroyCategoryPictures($category);
        $this->categoryRepository->delete($category->id);
        return SuccessResource::make([
            'message' => trans('message.successfully_deleted'),
        ]);

    }
}
