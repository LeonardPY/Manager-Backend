<?php

namespace App\Http\Requests\Category;

use App\Exceptions\ApiErrorException;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ShowCategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     * @throws ApiErrorException
     */
    public function authorize(): bool
    {
        $user = authUser();
        return $this->category->user_id === $user->id || $user->isAdmin();
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
