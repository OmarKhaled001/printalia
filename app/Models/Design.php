<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Design extends Model
{
    use HasFactory;

    protected $fillable = [
        'designer_id',
        'product_id',
        'sale_price',
        'title',
        'description',
        'rating',
        'is_published',
        'image_front',
        'image_back'
    ];

    public function designer()
    {
        return $this->belongsTo(Designer::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
