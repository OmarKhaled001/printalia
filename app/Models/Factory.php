<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Filament\Models\Contracts\FilamentUser;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Factory extends Authenticatable implements FilamentUser
{
    use HasFactory, Notifiable;

    public function canAccessPanel(\Filament\Panel $panel): bool
    {
        return true;
    }
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

    public function subscriptions()
    {
        return $this->morphMany(Subscription::class, 'subscribable');
    }
}
