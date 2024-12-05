<?php

namespace App\Http\Requests\Product;

use App\Exceptions\ApiErrorException;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class DestroyProductRequest extends FormRequest
{
    /** @throws ApiErrorException */
    public function authorize(): bool
    {
        $user = authUser();
        return $this->product->user_id === $user->id || $user->isAdmin();
    }

    /**  @return array<string, ValidationRule|array|string> */
    public function rules(): array
    {
        return [
            //
        ];
    }
}
