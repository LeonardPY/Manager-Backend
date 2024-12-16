<?php

namespace App\Http\Requests\Product;

use App\Exceptions\ApiErrorException;
use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;

class DestroyProductRequest extends FormRequest
{
    /** @throws ApiErrorException */
    public function authorize(): bool
    {
        $user = authUser();
        /** @var Product $product */
        $product = $this->product ?? throw new ApiErrorException(trans('message.not_found'), 404);
        return $product->user_id === $user->id || $user->isAdmin();
    }
}
