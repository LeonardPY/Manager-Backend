<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Model\RefundOrderProduct
 *
 * @property int $refund_order_id
 * @property int $product_id
 * @property int $quantity
 * @property int $price
 * @property RefundOrder $refundOrder
*/
class RefundOrderProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'refund_order_id',
        'product_id',
        'quantity',
        'price'
    ];

    public function refundOrder(): BelongsTo
    {
        return $this->belongsTo(RefundOrder::class, 'refund_order_id', 'id');
    }
}
