<?php

namespace App\Http\Requests\Category;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'min:3',
                'max:80'
            ],
            'name_am' => [
                'required',
                'string',
                'min:3',
                'max:80'
            ],
            'parent_id' => [
                'nullable',
                'exists:categories,id'
            ],
            'picture' => [
                'required',
                'image',
                'mimes:jpeg,png,jpg,svg,webp',
                'max:2048'
            ],
            'banner_picture' => [
                'nullable',
                'image',
                'mimes:jpeg,png,jpg,svg,webp',
                'max:2048'
            ],
        ];
    }
}
