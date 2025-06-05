<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'subscribable_id',
        'subscribable_type',
        'plan_id',
        'bank_account_id',
        'start_date',
        'end_date',
        'status',
        'receipt',
        'amount',
        'is_approved',
        'notes'
    ];

    public function subscribable()
    {
        return $this->morphTo();
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    public function account()
    {
        return $this->belongsTo(BankAccount::class);
    }
}
