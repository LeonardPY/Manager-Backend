<?php

namespace App\Http\Requests\RefundOrder;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class RefundOrderRequest extends FormRequest
{

    /** @return array<string, ValidationRule|array|string> */
    public function rules(): array
    {
        return [
            'order_product_id' => [
                'required',
                'exists:order_products,id'
            ],
            'quantity' => [
                'required',
                'integer',
                'min:1'
            ],
        ];
    }
}
