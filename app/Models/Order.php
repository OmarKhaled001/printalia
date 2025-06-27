<?php

// File: app/Models/Order.php
// --- النسخة النهائية والصحيحة ---

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Order extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     * تم تحديث هذه القائمة لتتوافق مع هيكل الطلب متعدد المنتجات.
     */
    protected $fillable = [
        'customer_id',
        'designer_id',
        'factory_id',
        'total',
        'status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'total' => 'float',
    ];

    /**
     * Get the customer that owns the order.
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Get the designer associated with the order.
     * You might need to change this to the correct User model if you have one.
     */
    public function designer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'designer_id');
    }

    /**
     * The products that belong to the order.
     */
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'order_product')
            ->withPivot('quantity', 'price', 'size') // لجلب الكمية والسعر من الجدول الوسيط
            ->withTimestamps();
    }
}
