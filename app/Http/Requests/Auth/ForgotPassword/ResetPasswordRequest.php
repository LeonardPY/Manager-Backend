<?php

namespace App\Http\Requests\Auth\ForgotPassword;

use Illuminate\Foundation\Http\FormRequest;

class ResetPasswordRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => 'required',
            'password' => 'required|string|min:6|confirmed',
        ];
    }
}
