<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserAddressResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'address_line1' => $this->resource->address_line1,
            'address_line2' => $this->resource->address_line2,
            'city' => $this->resource->city,
            'state_or_province' => $this->resource->state_or_province,
            'latitude' => $this->resource->latitude,
            'longitude' => $this->resource->longitude,

            'user' => $this->resource->user,
            'country' => $this->resource->country,

        ];
    }
}
