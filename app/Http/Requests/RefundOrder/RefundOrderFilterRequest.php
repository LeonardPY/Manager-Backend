<?php

namespace App\Http\Requests\RefundOrder;

use App\Enums\RefundStatus;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class RefundOrderFilterRequest extends FormRequest
{

    /** @return array<string, ValidationRule|array|string> */
    public function rules(): array
    {
        return [
            'status' => ['nullable', new Enum(RefundStatus::class)],
        ];
    }
}
