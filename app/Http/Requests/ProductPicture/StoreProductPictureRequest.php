<?php

namespace App\Http\Requests\ProductPicture;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreProductPictureRequest extends FormRequest
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
            'pictures' => [
                'required',
                'array',
                'min:1',
                'max:10'
            ],
            'pictures.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }
}
