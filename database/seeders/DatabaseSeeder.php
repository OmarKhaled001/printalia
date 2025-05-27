<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Factory;
use App\Models\Designer;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::create([
            'name' => 'Admin',
            'email' => 'admin@printalia.com',
            'password' => Hash::make('password'),
        ]);

        Designer::create([
            'name' => 'Designer',
            'email' => 'designer@printalia.com',
            'password' => Hash::make('password'),
        ]);

        Factory::create([
            'name' => 'Factory',
            'email' => 'factory@printalia.com',
            'password' => Hash::make('password'),
        ]);

        $this->call(PlanSeeder::class);
    }
}
