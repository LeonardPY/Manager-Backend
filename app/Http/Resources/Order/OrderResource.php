<?php

declare(strict_types=1);

namespace App\Http\Resources\Order;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends BaseOrderResource
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
            'department' => $this->resource->department,
            'shipping_data' => $this->resource->shipping_data,
            'order_products' => $this->resource->orderProducts,
        ];
    }
}
