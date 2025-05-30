<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
        'logo_back',
        'logo_front',
        'image_front',
        'image_back'
    ];

    protected $appends = ['front_image_url', 'back_image_url'];

    public function getFrontImageUrlAttribute()
    {
        return $this->image_front ? Storage::url($this->image_front) : null;
    }

    public function getBackImageUrlAttribute()
    {
        return $this->image_back ? Storage::url($this->image_back) : null;
    }

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
