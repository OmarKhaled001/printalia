<?php

namespace App\Models;

use Illuminate\Support\Facades\Storage;
use Filament\Models\Contracts\HasAvatar;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

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
        'avatar_url',
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

    public function subscriptions()
    {
        return $this->morphMany(Subscription::class, 'subscribable');
    }
}
