<?php

namespace App\Http\Requests\User\Department;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class FilterDepartmentRequest extends FormRequest
{
    /** @return array<string, ValidationRule|array|string> */
    public function rules(): array
    {
        return [
            'name' => [
                'nullable',
                'string',
            ],
            'last_name' => [
                'nullable',
                'string',
            ],
            'page' => 'nullable|integer:min:1',
            'limit' => 'nullable|integer:min:1',
        ];
    }
}
