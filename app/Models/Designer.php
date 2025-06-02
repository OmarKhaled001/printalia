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

    protected $casts = [
        'is_verified' => 'boolean',
        'is_active' => 'boolean',
        'has_active_subscription' => 'boolean',
        'attachments' => 'array',
    ];


    protected $hidden = [
        'password',
    ];

    public function customers()
    {
        return $this->hasMany(Customer::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function designs()
    {
        return $this->hasMany(Design::class);
    }

    public function subscriptions()
    {
        return $this->morphMany(Subscription::class, 'subscribable');
    }

    public function activeSubscription()
    {
        return $this->subscriptions()->where('is_approved', true)->where('end_date', '>=', now())->latest()->first();
    }

    public function designsUsedCount(): int
    {
        return $this->designs()->count();
    }

    public function remainingDesigns(): int
    {
        $plan = $this->activeSubscription()?->plan;
        return max(0, ($plan->design_limit ?? 0) - $this->designsUsedCount());
    }

    public function daysLeftInSubscription(): int
    {
        $end = optional($this->activeSubscription())->end_date;
        return now()->diffInDays($end, false);
    }
}
