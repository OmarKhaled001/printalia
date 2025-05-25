<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Plan extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'duration',
        'duration_unit',
        'description',
        'design_count',
        'is_active',
    ];

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function calculateEndDate($startDate)
    {
        return match ($this->duration_unit) {
            'day', 'days' => $startDate->copy()->addDays($this->duration),
            'month', 'months' => $startDate->copy()->addMonths($this->duration),
            'year', 'years' => $startDate->copy()->addYears($this->duration),
            default => $startDate->copy()->addDays($this->duration),
        };
    }
}
