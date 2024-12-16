<?php

namespace App\Http\Controllers\Api\Department;

use App\Enums\PicturesPathEnum;
use App\Exceptions\ApiErrorException;
use App\Http\Controllers\Controller;
use App\Http\Resources\ErrorResource;
use App\Http\Resources\SuccessResource;
use App\Models\ProductPicture;
use App\Repositories\Eloquent\ProductPictureRepository;
use App\Services\FilesystemService;

class ProductPictureController extends Controller
{
    public function __construct(
        private readonly ProductPictureRepository $productPictureRepository,
        private readonly FilesystemService        $pictureService
    ) {
    }

    /** @throws ApiErrorException */
    public function destroy(int $id): SuccessResource|ErrorResource
    {
        /** @var ProductPicture $productPicture */
        $productPicture = $this->productPictureRepository->findOrFail($id);
        $user = authUser();
        if ($productPicture->product->haveAccess($user->id) || $user->isAdmin()) {
            $this->pictureService->destroyPicture(
                PicturesPathEnum::PRODUCT->value . '/' . $productPicture->product->id . '/' . $productPicture->path
            );
            $this->productPictureRepository->delete($productPicture->id);
            return SuccessResource::make([
                'message' => trans('message.successfully_deleted'),
            ]);
        }
        return ErrorResource::make([
            'message' => trans('message.access_denied'),
        ])->setStatusCode(403);
    }
}
