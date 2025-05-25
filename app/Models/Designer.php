<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Designer extends Authenticatable
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
        'is_active',
        'profile',
        'attachments',
        'has_active_subscription'
    ];

    protected $hidden = [
        'password',
    ];

    public function customers()
    {
        return $this->hasMany(Customer::class);
    }

    public function designs()
    {
        return $this->hasMany(Design::class);
    }

    public function subscription(): MorphOne
    {
        return $this->morphOne(Subscription::class, 'subscribable');
    }
}
