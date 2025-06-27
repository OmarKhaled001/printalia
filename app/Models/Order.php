<?php

namespace App\Models;

use App\Enums\StatusTypes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['customer_id', 'designer_id', 'design_id', 'quantity', 'price', 'size', 'total'];


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
