<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubscriptionReview extends Model
{
    use HasFactory;

    protected $fillable = ['subscription_id', 'admin_id', 'is_approved', 'notes'];

    public function subscription()
    {
        return $this->belongsTo(Subscription::class);
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}
