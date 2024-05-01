<?php

namespace App\Http\Resources\Product;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'product_code' => $this->resource->product_code,
            'name' => $this->resource->name,
            'name_am' => $this->resource->name_am,
            'price' => $this->resource->price,
            'old_price' => $this->resource->old_price,
            'count' => $this->resource->count,
            'discount_percent' => $this->resource->discount_percent,
            'status' => $this->resource->status->getProductstatus(),


            'category' => $this->resource->category,
            'mainPicture' => $this->resource->mainPicture
        ];
    }
}
