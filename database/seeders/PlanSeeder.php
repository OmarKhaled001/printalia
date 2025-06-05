<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Plan;

class PlanSeeder extends Seeder
{
    public function run(): void
    {
        Plan::create([
            'name' => 'خطة المبتدئ',
            'price' => 90.00,
            'duration' => 30,
            'duration_unit' => 'day',
            'description' => 'خطة شهرية تشمل 9 تصميمات',
            'design_count' => 9,
            'is_active' => true,
        ]);

        Plan::create([
            'name' => 'خطة المحترف',
            'price' => 120.00,
            'duration' => 30,
            'duration_unit' => 'day',
            'description' => 'خطة شهرية تشمل 12 تصميم',
            'design_count' => 12,
            'is_active' => true,
        ]);

        Plan::create([
            'name' => 'خطة اللامحدود',
            'price' => 150.00,
            'duration' => 30,
            'duration_unit' => 'day',
            'description' => 'عدد لا نهائي من التصميمات لمدة شهر',
            'design_count' => null,
            'is_active' => true,
            'is_infinity' => true,
        ]);
    }
}
