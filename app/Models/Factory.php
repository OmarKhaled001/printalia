<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Factory extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'national_id',
        'address',
        'password',
        'is_verified',
        'logo',
        'attachments',
        'has_active_subscription'
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'attachments' => 'array',
    ];


    public function factoryOrders()
    {
        return $this->hasMany(FactoryOrder::class);
    }

    public function subscription(): MorphOne
    {
        return $this->morphOne(Subscription::class, 'subscribable');
    }
}
