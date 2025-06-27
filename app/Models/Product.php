<?php

// File: app/Models/Product.php
// --- النسخة النهائية والصحيحة ---

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'sku',
        'price',
        'description',
        'is_double_sided',
        'has_sizes',
        'is_published',
        'image_front',
        'image_back'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'price' => 'float',
        'is_double_sided' => 'boolean',
        'has_sizes' => 'boolean',
        'is_published' => 'boolean',
    ];

    /**
     * The orders that belong to the product.
     */
    public function orders(): BelongsToMany
    {
        return $this->belongsToMany(Order::class, 'order_product')
            ->withPivot('quantity', 'price', 'size')
            ->withTimestamps();
    }

    // The SKU generation logic is good, no changes needed.
    public static function generateSku(): string
    {
        do {
            $sku = 'PRD-' . strtoupper(str()->random(8));
        } while (self::where('sku', $sku)->exists());

        return $sku;
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            if (empty($product->sku)) {
                $product->sku = self::generateSku();
            }
        });
    }
}
