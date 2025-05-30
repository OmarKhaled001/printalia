<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'sku', 'price', 'description', 'is_double_sided', 'is_published', 'image_front', 'image_back'];


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
}
