<?php

namespace App\Models;

use App\Enums\StatusTypes;
use Illuminate\Support\Str;
use App\Enums\TransactionType;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

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
        'has_active_subscription',
        'referral_code',
        'referred_by',
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

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
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

    public function referrer()
    {
        return $this->belongsTo(Designer::class, 'referred_by');
    }

    public function referrals()
    {
        return $this->hasMany(Designer::class, 'referred_by');
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

    protected static function booted()
    {
        static::creating(function ($designer) {
            if (empty($designer->referral_code)) {
                $designer->referral_code = self::generateUniqueReferralCode();
            }
        });
    }


    public static function generateUniqueReferralCode(): string
    {
        do {
            $code = strtoupper(Str::random(6));
        } while (self::where('referral_code', $code)->exists());

        return $code;
    }

    public function getPendingReferralEarnings(): float
    {
        return $this->transactions()
            ->where('type', TransactionType::REFERRAL)
            ->where('status', StatusTypes::Pending)
            ->sum('amount');
    }


    public function getFinishedReferralEarnings(): float
    {
        return $this->transactions()
            ->where('type', TransactionType::REFERRAL)
            ->where('status', StatusTypes::Finished)
            ->sum('amount');
    }
}
