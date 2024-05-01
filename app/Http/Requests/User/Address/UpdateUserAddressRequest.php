<?php

namespace App\Http\Requests\User\Address;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUserAddressRequest extends FormRequest
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
            'country_id' => [
                'required',
                'sometimes',
                'int',
                'exists:countries,id'
            ],
            'address_line1' => [
                'required',
                'sometimes',
                'string'
            ],
            'address_line2' => [
                'required',
                'sometimes',
                'string',
                'regex:/^[1-9]\d*(?: ?(?:[a-z]|[\/-] ?\d+[a-z]?))?/i'
            ],
            'city' => [
                'required',
                'sometimes',
                'string'
            ],
            'state_or_province' => [
                'required',
                'sometimes',
                'string'
            ],
            'latitude' => [
                'nullable',
                'numeric',
            ],
            'longitude' => [
                'nullable',
                'numeric',
            ],
        ];
    }
}
