<?php

declare(strict_types=1);

namespace App\Http\Resources\Order;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            'status' => $this->resource->order_status_id,
            'total_price'=> $this->resource->total_price,
            'user_address_id' => $this->resource->user_address_id,

            'user' => $this->resource->user,
            'department' => $this->resource->department,
            'shipping_data' => $this->resource->shipping_data,
            'order_products' => $this->resource->orderProducts,

            'created_at'     => $this->resource->created_at,
            'updated_at'     => $this->resource->updated_at
        ];
    }
}
