<?php

namespace App\Http\Controllers\Api\Department;

use App\Enums\PicturesPathEnum;
use App\Http\Controllers\Controller;
use App\Http\Resources\ErrorResource;
use App\Http\Resources\SuccessResource;
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

    public function destroy(int $id): SuccessResource|Response
    {
        $productPicture = $this->productPictureRepository->findOrFail($id);
        if($productPicture->product->haveAccess(auth()->id()) || auth()->user()->isAdmin()) {
            $this->pictureService->destroyPicture(PicturesPathEnum::PRODUCT->value . '/' . $productPicture->product->id. '/' . $productPicture->path);
            $productPicture->delete();
            return SuccessResource::make([
                'message' => 'success!'
            ]);
        };
        return (new ErrorResource([
            'message' => 'Forbidden'
        ]))->response()->setStatusCode(403);
    }
}
