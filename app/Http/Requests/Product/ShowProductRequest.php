<?php

namespace App\Http\Requests\Product;

use App\Exceptions\ApiErrorException;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ShowProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     * @throws ApiErrorException
     */
    public function authorize(): bool
    {
        $user = authUser();
        return $this->product->user_id === $user->id || $user->isAdmin();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            //
        ];
    }
}
