<?php

namespace App\Models;

use App\Enums\StatusTypes;
use App\Enums\FactoryOrderStatus;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FactoryOrder extends Model
{
    use HasFactory;

    protected $fillable = ['order_id', 'factory_id', 'status'];

    protected $casts = [
        'status' => StatusTypes::class,
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function factory()
    {
        return $this->belongsTo(Factory::class);
    }

    public static function boot()
    {
        parent::boot();

        static::updated(function ($factoryOrder) {
            if ($factoryOrder->status === 'rejected') {
                $order = $factoryOrder->order;

                $excludedFactoryIds = $order->factoryOrders->pluck('factory_id')->toArray();

                $newFactory = Factory::whereNotIn('id', $excludedFactoryIds)->inRandomOrder()->first();

                if ($newFactory) {
                    FactoryOrder::create([
                        'order_id' => $order->id,
                        'factory_id' => $newFactory->id,
                        'status' => 'pending',
                    ]);
                } else {
                    Log::warning("No available factory to reassign order ID {$order->id}");
                }
            }
        });
    }
}
