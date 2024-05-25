<?php

namespace App\Http\Resources\Product;

use Illuminate\Http\Request;

class ProductResource extends BaseProductResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return array_merge(parent::toArray($request), [
            'category' => $this->resource->category,
            'mainPicture' => $this->resource->mainPicture,
            'description' => $this->resource->description
        ]);
    }
}
