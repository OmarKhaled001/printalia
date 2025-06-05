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
        'is_infinity',
    ];

    protected $casts = [
        'duration' => 'integer',
    ];


    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function calculateEndDate($startDate)
    {
        $duration = (int) $this->duration;

        return match ($this->duration_unit) {
            'day', 'days' => $startDate->copy()->addDays($duration),
            'month', 'months' => $startDate->copy()->addMonths($duration),
            'year', 'years' => $startDate->copy()->addYears($duration),
            default => $startDate->copy()->addDays($duration),
        };
    }
}
