<?php

namespace App\Models;

use App\Models\Traits\Filterable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 *  App\Models\RefundOrder
 *
 * @property int id
 * @property int order_id
 * @property int user_id
 * @property int department_id
 * @property array shipping_data
 * @property float total_price
 * @property string currency
 * @property string status
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property RefundOrderProduct[] $refundProducts
 *
*/

class RefundOrder extends Model
{
    use Filterable;
    use HasFactory;

    public $timestamps = true;

    protected $fillable = [
        'order_id',
        'user_id',
        'department_id',
        'shipping_data',
        'total_price',
        'currency',
        'refunded_price',
        'status'
    ];

    /** @return array<string, mixed> */
    public function casts(): array
    {
        return [
            'shipping_data' => 'array'
        ];
    }

    public function refundProducts(): HasMany
    {
        return $this->hasMany(RefundOrderProduct::class, 'refund_order_id', 'id');
    }

    public function store(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function factory(): BelongsTo
    {
        return $this->belongsTo(User::class, 'department_id', 'id');
    }
}
