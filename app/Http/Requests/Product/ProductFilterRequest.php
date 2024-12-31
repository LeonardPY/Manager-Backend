<?php

namespace App\Http\Requests\Product;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ProductFilterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => [
                'nullable',
                'string',
                'min:1'
            ],
            'name_am' => [
                'nullable',
                'string',
                'min:1'
            ],
            'price_from' => [
                'nullable'
            ],
            'price_to' => [
                'nullable'
            ],
            'category' => [
                'nullable',
                'exists:categories,id'
            ],
            'brand_id' => [
                'nullable',
                'string'
            ],
            'page' => [
                'nullable',
                'int',
                'min:1'
            ],
            'limit' => [
                'nullable',
                'int',
                'min:1'
            ]
        ];
    }
}
