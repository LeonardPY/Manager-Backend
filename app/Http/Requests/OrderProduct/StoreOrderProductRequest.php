<?php

namespace App\Http\Requests\OrderProduct;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreOrderProductRequest extends FormRequest
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
            'department_id' => [
                'required',
                'int',
                'exists:users,id'
            ],
            'product_id' => [
                'required',
                'int',
                'exists:products,id'
            ],
            'quantity' => [
                'required',
                'int',
                'min:1'
            ],
        ];
    }
}
