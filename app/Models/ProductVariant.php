<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'sku',
        'name',
        'attributes',
        'price',
        'stock',
        'is_default',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'attributes' => 'array',
        'price' => 'decimal:2',
        'stock' => 'integer',
        'is_default' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function images()
    {
        return $this->belongsToMany(
            ProductImage::class,
            'product_variant_images',
            'product_variant_id',
            'product_image_id'
        );
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function getEffectivePrice()
    {
        return $this->price ?? $this->product->price;
    }

    public function getDiscountedPrice()
    {
        $basePrice = $this->getEffectivePrice();
        $discount = $this->product->discount ?? 0;

        if ($discount > 0) {
            return $basePrice - ($basePrice * $discount / 100);
        }

        return $basePrice;
    }

    public function isInStock(): bool
    {
        return $this->stock > 0;
    }
}
