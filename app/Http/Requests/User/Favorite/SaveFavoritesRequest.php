<?php

namespace App\Http\Requests\User\Favorite;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class SaveFavoritesRequest extends FormRequest
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
            'favorites' => [
                'required',
                'array'
            ],
            'favorites.*.product_id' => [
                'required',
                'exists:products,id'
            ]
        ];
    }
}
