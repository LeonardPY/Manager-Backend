<?php

namespace App\Models;

use App\Casts\DateFormatCast;
use App\Enums\OrderStatus;
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
 * @property string currency
 * @property float total_price
 * @property string $created_at
 * @property string $updated_at
 * @property OrderProduct[] $orderProducts
 * @property User $department
 * @property User $user
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

    public function casts(): array
    {
        return [
            'shipping_data' => 'json',
            'shipping_cost' => 'decimal:2',
            'insurance_cost' => 'decimal:2',
            'created_at' => DateFormatCast::class,
            'updated_at' => DateFormatCast::class,
        ];
    }

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
        return $this->user_id === $userId && $this->status === OrderStatus::IN_CART->value;
    }

    public function haveProcessAccessRefund(int $userId): bool
    {
        return $this->user_id === $userId && $this->status === OrderStatus::SHIPPED->value;
    }
}
