<?php

namespace App\Http\Requests\Department;

use App\Enums\OrderStatus;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class OrderUpdateRequest extends FormRequest
{
    /** @return array<string, ValidationRule|array|string> */
    public function rules(): array
    {
        return [
            'status' => ['nullable', Rule::In([
                OrderStatus::CONFIRM->value,
                OrderStatus::CONFIRM_DELIVERY->value
            ])]
        ];
    }
}
