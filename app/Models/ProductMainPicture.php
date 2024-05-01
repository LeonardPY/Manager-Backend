<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductMainPicture extends Model
{
    use HasFactory;

    protected $table = 'product_main_pictures';
    protected $fillable = [
        'product_id',
        'picture',
        'medium_picture',
        'small_picture'
    ];

    public $timestamps = false;

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
