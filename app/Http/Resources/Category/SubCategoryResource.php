<?php

namespace App\Http\Resources\Category;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SubCategoryResource extends JsonResource
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
            'title' => $this->resource->title,
            'status'=> $this->resource->status->getCategoryStatus(),
            'picture'=> $this->resource->picture ,
            'banner_picture' => $this->resource->banner_picture,
            'subCategory' => $this->resource->subCategory
        ];
    }
}
