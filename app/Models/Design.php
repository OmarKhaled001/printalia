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
        'rating', // Assuming you might add this later
        'is_published',
        'logo_back',   // Will store JSON string or be cast to array
        'logo_front',  // Will store JSON string or be cast to array
        'image_front', // Will store path to the final composite image (transparent)
        'image_back'   // Will store path to the final composite image (transparent)
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'is_published' => 'boolean',
        'sale_price' => 'float',
        'logo_front' => 'array', // Automatically encodes/decodes JSON
        'logo_back' => 'array',  // Automatically encodes/decodes JSON
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
        // Assuming you have a User model or a specific Designer model
        return $this->belongsTo(User::class, 'designer_id'); // Or Designer::class
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function orders()
    {
        // Assuming you have an Order model
        return $this->hasMany(Order::class);
    }
}
