<?php

namespace App\Http\Requests\User\Admin;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
                'required',
                'sometimes',
                'string',
                'min:3',
                'max:255',
            ],
            'last_name' => [
                'required',
                'sometimes',
                'string',
                'min:3',
                'max:255',
            ],
            'user_role_id' => [
                'required',
                'sometimes',
                'sometimes',
                'exists:user_roles,id'
            ],
            'email' => [
                'required',
                'sometimes',
                'email',
                'unique:users,email'
            ],
            'password' => [
                'required',
                'sometimes',
                'string',
                'min:6',
                'confirmed'
            ],
        ];
    }
}
