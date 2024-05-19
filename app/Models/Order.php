<?php

namespace App\Models;

use App\Models\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;


/**
 * App\Models\Order
 *
 * @property int id
 * @property int user_id
 * @property int department_id
 * @property int user_address_id
 * @property int status
 * @property array shipping_data
 * @property float total_price
 */
class Order extends Model
{
    use HasFactory;
    use Filterable;

    protected $fillable = [
        'user_id',
        'department_id',
        'user_address_id',
        'status',
        'shipping_data',
        'total_price',
        'currency',
        'shipping_cost',
        'insurance_cost',
        'refunded_price'
    ];

    protected $casts = [
        'shipping_data' => 'json',
        'shipping_cost' => 'decimal:2',
        'insurance_cost' => 'decimal:2'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(User::class, 'department_id', 'id');
    }

    public function address(): BelongsTo
    {
        return $this->belongsTo(UserAddress::class, 'user_address_id', 'id');
    }

    public function orderProducts(): HasMany
    {
        return $this->hasMany(OrderProduct::class, 'order_id', 'id');
    }

    public function haveProcessAccess(int $userId): bool
    {
        return $this->user_id === $userId && $this->status === \App\Enums\OrderStatus::IN_CART->value;
    }
}
