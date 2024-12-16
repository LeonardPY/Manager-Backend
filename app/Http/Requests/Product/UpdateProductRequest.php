<?php

namespace App\Http\Requests\Product;

use App\Enums\ProductStatusEnum;
use App\Exceptions\ApiErrorException;
use App\Models\Product;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class UpdateProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     * @throws ApiErrorException
     */
    public function authorize(): bool
    {
        $user = authUser();
        /** @var Product $product */
        $product = $this->product ?? throw new ApiErrorException(trans('message.not_found'), 404);
        return $product->user_id === $user->id || $user->isAdmin();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'sometimes|required|string|max:255',
            'name_am' => 'sometimes|required|string|max:255',
            'price' => 'sometimes|required|numeric|min:0',
            'old_price' => 'sometimes|nullable|numeric|min:0',
            'purchase_price' => 'sometimes|nullable|numeric|min:0',
            'count' => 'sometimes|required|integer|min:0',
            'category_id' => [
                'nullable',
                'exists:categories,id'
            ],
            'brand_id' => 'nullable|exists:brands,id',
            'product_code' => 'sometimes|nullable|string|min:0',
            'status' => [
                'required',
                'sometimes',
                'int',
                new Enum(ProductStatusEnum::class)
            ],
            'discount_percent' => [
                'sometimes',
                'min:0',
                'max:100'
            ],
            'picture' => 'sometimes|required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }
}
