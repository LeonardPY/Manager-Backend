<?php

declare(strict_types=1);

namespace App\Http\Resources\Order;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BaseOrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray(Request $request): array
    {
        return [
            'id' =>  $this->resource->id,
            'user_id' =>  $this->resource->user_id,
            'status' => $this->resource->status,
            'total_price'=> $this->resource->total_price,
            'currency'=> $this->resource->currency,
            'user_address_id' => $this->resource->user_address_id,

            'created_at' => $this->resource->created_at,
            'updated_at' => $this->resource->updated_at
        ];
    }
}
