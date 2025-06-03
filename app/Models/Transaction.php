<?php

namespace App\Models;

use App\Enums\StatusTypes;
use App\Enums\TransactionType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaction extends Model
{

    use HasFactory;

    protected $fillable = [
        'order_id',
        'factory_id',
        'designer_id',
        'status',
        'type',
        'receipt_image',
        'amount',
    ];

    protected $casts = [
        'status' => StatusTypes::class,
        'type' => TransactionType::class,
    ];


    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function factory()
    {
        return $this->belongsTo(Factory::class);
    }

    public function designer()
    {
        return $this->belongsTo(Designer::class);
    }
}
