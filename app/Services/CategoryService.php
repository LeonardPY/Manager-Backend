<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\PicturesPathEnum;
use App\Repositories\CategoryRepositoryInterface;
use Illuminate\Support\Str;

readonly class CategoryService
{
    public function __construct(
        private CategoryRepositoryInterface $categoryRepository,
        private FilesystemService $pictureService
    ) {
    }

    public function uploadStoreCategoryPictures(array $data, ?int $categoryId = null): array
    {
        if(!$categoryId) {
            $lastCategory = $this->categoryRepository->last();
            $categoryId = $lastCategory ? $lastCategory->id + 1 : 1;
        }
        if (isset($data['picture'])) {
            $data['picture'] = $this->pictureService->uploadPicture(
                $data['picture'],
                PicturesPathEnum::CATEGORY_PICTURES->value. '/'. $categoryId . PicturesPathEnum::CATEGORY_IMAGE->value
            );
        }
        if (isset($data['banner_picture'])) {
            $data['banner_picture'] = $this->pictureService->uploadPicture(
                $data['banner_picture'],
                PicturesPathEnum::CATEGORY_PICTURES->value. '/'. $categoryId . PicturesPathEnum::CATEGORY_BANNER->value
            );
        }
        return $data;
    }

    public function uploadUpdateCategoryPictures(array $data, object $category): array
    {
        if (isset($data['picture'])) {
            $this->pictureService->destroyPicture($category->picture);
        }
        if (isset($data['banner_picture'])) {
            $this->pictureService->destroyPicture($category->banner_picture);
        }
        return $this->uploadStoreCategoryPictures($data, $category->id);
    }

    public function destroyCategoryPictures(object $category): void
    {
        $this->pictureService->destroyPicture($category->picture);
        $this->pictureService->destroyPicture($category->banner_picture);
    }

    public function generateSlug(string $name): string
    {
        $slug = Str::slug($name, '-');

        return $this->makeUniqueSlug($slug);
    }

    private function makeUniqueSlug(string $slug): string
    {
        if (!$this->categoryRepository->slugExists($slug)) {
            return $slug;
        }
        $slug .= '-' . Str::random(3);

        return $this->makeUniqueSlug($slug);
    }

}

