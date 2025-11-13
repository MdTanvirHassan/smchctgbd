<?php

namespace Database\Seeders;

use App\Models\Setting;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Admin user
        User::factory()->create([
            'name' => 'Fouraxiz',
            'email' => 'admin@fouraxiz.com',
            'password' => Hash::make('sms123456'), // default password
        ]);
    }
}
