<?php

namespace App\Http\Controllers\Api\Department;

use App\Enums\PicturesPathEnum;
use App\Http\Controllers\Controller;
use App\Http\Resources\ErrorResource;
use App\Http\Resources\SuccessResource;
use App\Models\Product;
use App\Models\User;
use App\Repositories\Eloquent\ProductPictureRepository;
use App\Services\PictureService;
use Symfony\Component\HttpFoundation\Response;

class ProductPictureController extends Controller
{
    public function __construct(
        private readonly ProductPictureRepository     $productPictureRepository,
        private readonly PictureService               $pictureService
    )
    {
    }

    public function destroy(int $id): SuccessResource|ErrorResource
    {
        /** @var Product $product **/
        /** @var User $user **/
        $productPicture = $this->productPictureRepository->findOrFail($id);
        $user = auth()->user();
        if($productPicture->product->haveAccess(auth()->id()) || $user->isAdmin()) {
            $this->pictureService->destroyPicture(PicturesPathEnum::PRODUCT->value . '/' . $productPicture->product->id. '/' . $productPicture->path);
            $productPicture->delete();
            return SuccessResource::make([
                'message' => trans('messages.successfully_deleted'),
            ]);
        }
        return ErrorResource::make([
            'message' => trans('messages.access_denied'),
        ])->setStatusCode(403);
    }
}
