<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory()->create([
            'name' => 'User Demo',
            'email' => 'demo@example.com',
            'password' => 'demo123',
            'phone' => '+628123345678',
            'address' => 'Jl. Jendral Soedirman, Jakarta, Indonesia',
            'dob' => '1990-01-31',
            'gender' => 'male'
        ]);
    }
}
