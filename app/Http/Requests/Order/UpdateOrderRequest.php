<?php

namespace App\Http\Requests\Order;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateOrderRequest extends FormRequest
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
            'user_address_id' => [
                'required',
                'sometimes',
                'exists:user_addresses,id'
            ],
            'currency' => [
                'required',
                'sometimes',
                'exists:countries,currency'
            ]
        ];
    }
}
