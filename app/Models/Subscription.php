<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'subscribable_id',
        'plan_id',
        'subscribable_type',
        'start_date',
        'end_date',
        'status',
        'receipt',
        'is_approved',
        'notes'
    ];

    public function subscribable()
    {
        return $this->morphTo();
    }

    public function plan()
    {
        return $this->belongsTo(plan::class);
    }
}
