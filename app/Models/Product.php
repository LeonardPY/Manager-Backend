<?php

namespace App\Models;

use App\Enums\ProductStatusEnum;
use App\Models\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Product extends Model
{
    use HasFactory;
    use Filterable;

    protected $table = 'products';

    protected $fillable = [
        'name',
        'name_am',
        'slug',
        'price',
        'old_price',
        'purchase_price',
        'count',
        'status',
        'category_id',
        'user_id',
        'product_code',
        'discount_percent'
    ];

    protected $casts = [
        'status' => ProductStatusEnum::class,
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class,'user_id', 'id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function favorites(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'favorites', 'product_id', 'user_id');
    }

    public function mainPicture(): HasOne
    {
        return $this->hasOne(ProductMainPicture::class, 'product_id', 'id');
    }
}
