<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class FactorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $factories = [
            [
                'name' => 'مصنع الرياض للأثاث',
                'email' => 'info@riyadh-furniture.com',
                'phone' => '966112345678',
                'national_id' => '7001234567',
                'address' => 'الرياض، العليا، شارع الملك فهد',
                'password' => Hash::make('password'),
                'is_verified' => true,
                'has_active_subscription' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'مصنع جدة للبلاستيك',
                'email' => 'contact@jeddah-plastic.com',
                'phone' => '966126543210',
                'national_id' => '7007654321',
                'address' => 'جدة، حي السلامة، طريق الملك عبدالله',
                'password' => Hash::make('password'),
                'is_verified' => true,
                'has_active_subscription' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'مصنع الدمام للحديد',
                'email' => 'sales@dammam-steel.com',
                'phone' => '966138765432',
                'national_id' => '7009876543',
                'address' => 'الدمام، حي النخيل، شارع الأمير محمد بن فهد',
                'password' => Hash::make('password'),
                'is_verified' => 1,
                'has_active_subscription' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('factories')->insert($factories);
    }
}
