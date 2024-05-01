<?php

namespace App\Http\Requests\Category;

use App\Rules\DifferentCategoryIdRule;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $user = auth()->user();
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
            'name' => [
                'sometimes',
                'string',
                'min:3',
                'max:80'
            ],
            'name_am' => [
                'sometimes',
                'string',
                'min:3',
                'max:80'
            ],
            'parent_id' => [
                'nullable',
                'sometimes',
                'exists:categories,id',
                new DifferentCategoryIdRule($this->route('category'))
            ],
            'picture' => [
                'sometimes',
                'image',
                'mimes:jpeg,png,jpg,svg,webp',
                'max:2048'
            ],
            'banner_picture' => [
                'sometimes',
                'nullable',
                'image',
                'mimes:jpeg,png,jpg,svg,webp',
                'max:2048'
            ],
        ];
    }
}
