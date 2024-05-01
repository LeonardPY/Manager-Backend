<?php

namespace App\Http\Resources\Category;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
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
            'name' =>  $this->resource->name,
            'name_am' => $this->resource->name_am,
            'picture'=> $this->resource->picture ,
            'banner_picture' => $this->resource->banner_picture,
            'subCategory' => SubCategoryResource::collection($this->resource->subCategory),
        ];
    }
}
