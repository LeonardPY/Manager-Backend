<?php

namespace App\Http\Resources\Refund;

use App\Models\RefundOrder;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderRefundResource extends JsonResource
{
    /** @return array<string, mixed> */
    public function toArray(Request $request): array
    {
        /** @var RefundOrder $resource */
        $resource = $this->resource;
        return [
            'id' => $resource->id,
            'order_id' => $resource->order_id,
            'currency' => $resource->currency,
            'status' => $resource->status,
            'shipping_data' => $resource->shipping_data,

            'department' => $this->resource->factory ?? null,

            'created_at' => $resource->created_at->format('Y-m-d'),
            'updated_at' => $resource->updated_at->format('Y-m-d'),
        ];
    }
}
