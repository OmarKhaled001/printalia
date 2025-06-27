<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'sku', 'price', 'description', 'is_double_sided', 'has_sizes', 'is_published', 'image_front', 'image_back'];


    public function designs()
    {
        return $this->hasMany(Design::class);
    }


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

    public function orders(): BelongsToMany
    {
        return $this->belongsToMany(Order::class, 'order_product')
            ->withPivot('quantity', 'price')
            ->withTimestamps();
    }
}
