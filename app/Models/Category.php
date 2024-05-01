<?php

namespace App\Models;

use App\Models\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;
    use Filterable;

    protected $table = 'categories';

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'name',
        'name_am',
        'slug',
        'parent_id',
        'picture',
        'banner_picture',
    ];

    protected $casts = [
        'picture' => 'string',
        'banner_picture' => 'string',
    ];

    public function subCategory(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id', 'id');
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id', 'id');
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'category_id', 'id');
    }
}
