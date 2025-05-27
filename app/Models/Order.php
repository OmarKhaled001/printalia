<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['customer_id', 'design_id', 'quantity', 'price', 'total'];

    public function design()
    {
        return $this->belongsTo(Design::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
    public function designer()
    {
        return $this->belongsTo(Designer::class);
    }
    public function factoryOrders()
    {
        return $this->hasMany(FactoryOrder::class);
    }

    public function currentFactoryOrder()
    {
        return $this->hasOne(FactoryOrder::class)->latestOfMany();
    }
}
