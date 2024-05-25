<?php

namespace App\Models;

use App\Enums\ProductStatusEnum;
use App\Models\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * App\Models\Product
 *
 * @property int id
 * @property int user_id
 * @property string name
 * @property string slug
 * @property float price
 * @property float old_price
 * @property float purchase_price
 * @property float count
 * @property int status
 * @property int category_id
 * @property string product_code
 * @property float discount_percent
 * @property int parent_id
 */
class Product extends Model
{

    use HasFactory;
    use Filterable;

    protected $table = 'products';
    protected $appends =  ['discount_price'];

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
        'discount_percent',
        'parent_id'
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

    public function pictures(): HasMany
    {
        return $this->hasMany(ProductPicture::class, 'product_id', 'id');
    }

    public function description(): HasOne
    {
        return $this->hasOne(ProductDescription::class, 'product_id', 'id');
    }

    public function haveAccess(int $userId): bool
    {
        return $this->user_id === $userId;
    }

    public function getDiscountPriceAttribute(): string
    {
        if ($this->discount_percent) {
            $discountPrice = round((float)($this->price - $this->price * $this->discount_percent / 100), 2);
            return number_format($discountPrice, 2, '.', '');
        }
        return number_format($this->price, 2, '.', '');
    }
}
