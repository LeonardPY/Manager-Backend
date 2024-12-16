<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\PicturesPathEnum;
use App\Repositories\ProductMainPictureRepositoryInterface;
use App\Repositories\ProductRepositoryInterface;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Laravel\Facades\Image;

readonly class ProductService
{

    public function __construct(
        private ProductRepositoryInterface $productRepository,
        private ProductMainPictureRepositoryInterface $productMainPictureRepository,
        private FilesystemService $pictureService
    ) {
    }

    public function setProductCode(array $data): array
    {
        $data['product_code'] = Str::random(rand(6, 9));
        return $data;
    }

    public function generateSlug(string $name): string
    {
        $slug = Str::slug($name);

        return $this->makeUniqueSlug($slug);
    }

    private function makeUniqueSlug(string $slug): string
    {
        if (!$this->productRepository->slugExists($slug)) {
            return $slug;
        }
        $slug .= '-' . Str::random(3);

        return $this->makeUniqueSlug($slug);
    }

    //Main Picture
    public function mainUploadPicture(array $data, object $product): bool
    {
        if ($data['picture']) {
            $this->destroyUploadMainPicture($product);
            $mainPicture['picture'] = basename($this->pictureService->uploadPicture($data['picture'], PicturesPathEnum::PRODUCT->value . "/" . $product->id));
            $mainPicture['medium_picture'] = basename($this->resizePicture($data['picture'], $product->id, 600, 600, 'medium_'));
            $mainPicture['small_picture'] = basename($this->resizePicture($data['picture'], $product->id, 400, 400, 'small_'));

            $this->productMainPictureRepository->updateOrCreate([
                'product_id' => $product->id,
            ], $mainPicture);
        }

        return true;
    }

    private function resizePicture($picture, int $productId, int $width, int $height, string $prefix): string
    {
        $image = Image::read($picture)->resize($width, $height);
        $filenamePicture = uniqid($prefix) . '.png';
        $path = PicturesPathEnum::PRODUCT->value . "/" . $productId . '/' . $filenamePicture;
        Storage::disk(env('STORAGE_DISK'))->put($path, $image->encode());
        return $filenamePicture;
    }

    private function destroyUploadMainPicture(object $product): void
    {
        if ($product->mainPicture) {
            $this->pictureService->destroyPicture(PicturesPathEnum::PRODUCT->value . "/" . $product->id . "/" . $product->mainPicture->picture);
            $this->pictureService->destroyPicture(PicturesPathEnum::PRODUCT->value . "/" . $product->id . "/" . $product->mainPicture->medium_picture);
            $this->pictureService->destroyPicture(PicturesPathEnum::PRODUCT->value . "/" . $product->id . "/" . $product->mainPicture->small_picture);
        }
    }

    public function uploadPictures(array $pictures, int $productId): array
    {
        $picturesPath = [];
        foreach ($pictures['pictures'] as $picture) {
            $picturesPath[] = [
                'product_id' => $productId,
                'path' => basename($this->pictureService->uploadPicture($picture, PicturesPathEnum::PRODUCT->value . "/" . $productId))
            ];
        }
        return $picturesPath;
    }
}

