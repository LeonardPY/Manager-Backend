<?php

namespace App\Http\Requests\Worker;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreWorkerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /** @return array<string, ValidationRule|array|string> */
    public function rules(): array
    {
        return [
            'name' => 'required',
            'email' => 'required|email',
            'salary' => 'nullable|numeric|min:0',
            'picture' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'password' => 'required|min:8',
            'password_confirmation' => 'required|same:password',
        ];
    }
}
