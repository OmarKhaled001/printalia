<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DesignerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $designers = [
            [
                'name' => 'أحمد علي',
                'email' => 'ahmed_designer@example.com',
                'phone' => '01122334455',
                'national_id' => '56789012345678',
                'address' => 'الزمالك - القاهرة',
                'password' => Hash::make('password123'),
                'is_verified' => true,
                'is_active' => true,
                'profile' => null,
                'attachments' => null,
                'has_active_subscription' => true,
                'referral_code' => strtoupper(Str::random(10)),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'منى عبد الله',
                'email' => 'mona_designer@example.com',
                'phone' => '01233445566',
                'national_id' => '65432109876543',
                'address' => 'المعادي - القاهرة',
                'password' => Hash::make('password123'),
                'is_verified' => true,
                'is_active' => false,
                'profile' => null,
                'attachments' => null,
                'has_active_subscription' => false,
                'referral_code' => strtoupper(Str::random(10)),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'ليلى محمود',
                'email' => 'laila_designer@example.com',
                'phone' => '01077778888',
                'national_id' => '77889900112233',
                'address' => 'سيدي جابر - الإسكندرية',
                'password' => Hash::make('password123'),
                'is_verified' => true,
                'is_active' => true,
                'profile' => null,
                'attachments' => null,
                'has_active_subscription' => true,
                'referral_code' => strtoupper(Str::random(10)),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'يوسف جمال',
                'email' => 'youssef_designer@example.com',
                'phone' => '01522223333',
                'national_id' => '99001122334455',
                'address' => 'طنطا - الغربية',
                'password' => Hash::make('password123'),
                'is_verified' => false,
                'is_active' => true,
                'profile' => null,
                'attachments' => null,
                'has_active_subscription' => false,
                'referral_code' => strtoupper(Str::random(10)),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'سارة حسن',
                'email' => 'sara_designer@example.com',
                'phone' => '01288889999',
                'national_id' => '55667788990011',
                'address' => 'المنصورة - الدقهلية',
                'password' => Hash::make('password123'),
                'is_verified' => true,
                'is_active' => false,
                'profile' => null,
                'attachments' => null,
                'has_active_subscription' => true,
                'referral_code' => strtoupper(Str::random(10)),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('designers')->insert($designers);
    }
}
